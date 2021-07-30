const axios = require('axios').default;
const https = require('https')
const httpServer = require("http").createServer();
const io = require("socket.io")(httpServer, {
  cors: {
  origin: "*",
  methods: ["GET", "POST"],
  allowedHeaders: ["my-custom-header"],
  credentials: true
  }
  });


///const express = require('express');
//const app = express();
//const http = require('http');
//const server = http.createServer(app);
//const { Server } = require("socket.io");
//const io = new Server(server);

//app.get('/', (req, res) => {
 //   res.sendFile(__dirname + '/index.html');
//});
let users = [];

const addUser = (userId, socketId) => {
  !users.some((user)=> user.userId === userId) &&
    users.push({ userId, socketId });
}

const removeUser=(socketId)=>{
  users = users.filter(user=>user.socketId !==socketId);

}

const getuserbysocket = (socketId)=>{
  return users.find(users=>users.socketId == socketId);
 
}
const getUser = (userId)=>{

  return users.find(users=>users.userId == userId.toString());
 
}

io.on('connection', (socket) => {
    socket.on("addUser", (userId)=> {
      addUser(userId['userId'], socket.id);

      axios.post("http://127.0.0.1/SocialMedia/Old/Users/online/"+userId['userId'], {
      }, {
        headers: {'Content-Type': 'application/json'}
      }).then(function(response) {
      }).catch(function(error) {
      })
      io.emit("getUsers", users);
    });    
    socket.on('disconnect', () => { 
      var user = getuserbysocket(socket.id);
      if (user){
      ///GET USER ID HERE FOR REMOVING/////
      axios.post("http://127.0.0.1/SocialMedia/Old/Users/offline/"+user['userId'], {
      }, {
        headers: {'Content-Type': 'application/json'}
      })
    }
      removeUser(socket.id);
      io.emit("getUsers", users);
    });

    socket.on("typing", (recieverId)=> {
      const user = getUser(recieverId['recieverId']);
      if(user!=null){
      io.to(user.socketId).emit("typing")
    }
  }); 

  socket.on("adminContact", ({userId, recieverId})=>{
    console.log("working");

      const user = getUser(recieverId);
      const socketadmin = socket.id;
      if(user!=null){
        
        io.to(user.socketId).emit("admin", {
          userId,
          socketadmin,          
        })
      }
  });

    //send a message
    socket.on("sendMessage", ({userId, recieverId, text})=>{
      const user = getUser(recieverId);

      //preventing error if user isnt online
      if(user!=null){
      io.to(user.socketId).emit("getMessage", {
        userId, 
        text,
      })
    }
    })    
  });  
  httpServer.listen(3000, () => {
});