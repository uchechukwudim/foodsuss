/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var io = require('socket.io');

exports.initilize = function(server){
    io = io.listen(server);
    io.sockets.on("connection", function(socket){
        socket.send(JSON.stringify({type: 'serverMessage',
                    message: 'Welcome to this show'}));
                
            io.sockets.on('message', function (message){
            message = JSON.parse(message);
            if(message.type === 'userMessage'){
                socket.broadcast.send(JSON.stringify(message));
                message.type = 'myMessage';
                socket.send(JSON.stringify(message));
            }
        });
        
    });
};




