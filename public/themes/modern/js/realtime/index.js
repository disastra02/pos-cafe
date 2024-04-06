const express = require('express');
const { createServer } = require('node:http');
const { Server } = require('socket.io');

const app = express();
const server = createServer(app);
const io = new Server(server);

io.on('connection', (socket) => {
    console.log('a user connected');

    socket.on('kirimDapur', data => {
        io.emit('terimaDapur', data);
    })

    socket.on('perbaruiDapur', data => {
        io.emit('terimaPelayan', data);
    })

    socket.on('kirimKasir', data => {
        io.emit('terimaKasir', data);
    })

    socket.on('kirimAll', data => {
        io.emit('terimaAll', data);
    })
});

server.listen(3000, () => {
    console.log('server running');
});