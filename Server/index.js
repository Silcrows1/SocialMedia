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

//Users array for active users
let users = [];

const addUser = (userId, socketId) => {
  !users.some((user) => user.userId === userId) &&
    users.push({
      userId,
      socketId
    });
}

//remove user function
const removeUser = (socketId) => {
  users = users.filter(user => user.socketId !== socketId);
}

//Find user by using socketid
const getuserbysocket = (socketId) => {
  return users.find(users => users.socketId == socketId);
}

//Get users id
const getUser = (userId) => {
  return users.find(users => users.userId == userId.toString());
}

//On connection, allow socket functions
io.on('connection', (socket) => {

  //On add user, vall add user function to add to array.
  socket.on("addUser", (userId) => {
    addUser(userId['userId'], socket.id);

    //Axios to add userID as online
    axios.post("http://127.0.0.1/SocialMedia/Old/Users/online/" + userId['userId'], {}, {
      headers: {
        'Content-Type': 'application/json'
      }
    }).then(function (response) {}).catch(function (error) {})

    //Emit users array (consider removing)
    io.emit("getUsers", users);
  });

  //On disconnect remove user.
  socket.on('disconnect', () => {

    //Find user id using socketid
    var user = getuserbysocket(socket.id);

    //if user is found, use axios to remove offline user
    if (user) {
      axios.post("http://127.0.0.1/SocialMedia/Old/Users/offline/" + user['userId'], {}, {
        headers: {
          'Content-Type': 'application/json'
        }
      })
    }
    //Remove user function with socketid
    removeUser(socket.id);

    //emit all current users (Consider removing)
    io.emit("getUsers", users);
  });

  //On typing recieved function
  socket.on("typing", (recieverId) => {

    //get user information with userId
    const user = getUser(recieverId['recieverId']);

    //if user is found, emit to socket typing
    if (user != null) {
      io.to(user.socketId).emit("typing")
    }
  });

  //Admin contact function
  socket.on("adminContact", ({
    userId,
    recieverId
  }) => {
    //Get users with userid
    const user = getUser(recieverId);
    const socketadmin = socket.id;

    //if user is found emit admin to display pop up
    if (user != null) {
      io.to(user.socketId).emit("admin", {
        userId,
        socketadmin,
      })
    }
  });

  //on Cancelled function
  socket.on("admincancelled", ({
    userId,
    recieverId
  }) => {

    //get Users with userid
    const user = getUser(recieverId);

    //if user is found emit cancalled to display cancelled alert
    if (user != null) {
      io.to(user.socketId).emit("cancelled", {
        userId,
      })
    }
  });

  //on Accepted function
  socket.on("accepted", ({
    userId,
    recieverId
  }) => {
    console.log("accepted");

    //get Users with userid
    const user = getUser(recieverId);

    //if user is found emit cancalled to display cancelled alert
    if (user != null) {
      io.to(user.socketId).emit("accepted", {
        userId,
      })
    }
  });

  //send a message
  socket.on("sendMessage", ({
    userId,
    recieverId,
    text
  }) => {
    const user = getUser(recieverId);
    //preventing error if user isnt online
    if (user != null) {
      io.to(user.socketId).emit("getMessage", {
        userId,
        text,
      })
    }
  })
});
httpServer.listen(3000, () => {});