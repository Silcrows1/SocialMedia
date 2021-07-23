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
  console.log(users);
}

const getuserbysocket = (socketId)=>{
  return users.find(users=>users.socketId == socketId);
 
}
const getUser = (userId)=>{
  console.log(userId);  
  console.log(users);
  return users.find(users=>users.userId == userId.toString());
 
}

io.on('connection', (socket) => {
    console.log('a user connected');
    //io.emit("welcome", "welcome to the chat room")

    socket.on("addUser", (userId)=> {
      addUser(userId['userId'], socket.id);
      console.log(users);

      axios.post("http://127.0.0.1/SocialMedia/Old/Users/online/"+userId['userId'], {
      }, {
        headers: {'Content-Type': 'application/json'}
      }).then(function(response) {
      }).catch(function(error) {
      })
      io.emit("getUsers", users);
    });    
    console.log(socket.id);
    socket.on('disconnect', () => {
      console.log('user disconnected');     
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
      console.log(recieverId['recieverId']);
      const user = getUser(recieverId['recieverId']);
      //console.log(user);
      if(user!=null){
      io.to(user.socketId).emit("typing")
    }
  }); 

    //send a message
    socket.on("sendMessage", ({userId, recieverId, text})=>{
      console.log(userId);
      const user = getUser(recieverId);

      //preventing error if user isnt online
      if(user!=null){
      console.log(user);
      io.to(user.socketId).emit("getMessage", {
        userId, 
        text,
      })
    }
    })    
  });
  //send and recieve message
 
  
  io.on('connection', (socket) => {
    socket.on('chat message', (msg) => {
      io.emit('chat message', msg);
      console.log('chat message', msg);
    });
  });
  
  httpServer.listen(3000, () => {
  console.log('listening on *:3000');
});