let express = require('express');
let app = express();
let http = require('http').Server(app);
let io = require('socket.io')(http);

http.listen(3000, () => {
    console.log('Connection Done')
});

io.on('connection', (socket) => {
    console.log('There is a connection')

    socket.on('disconnect', () => {
        console.log('Disconnected')
    });

    socket.on('chatMessage', (msg) => {
        socket.broadcast.emit('chatMessage', msg)
    })
});