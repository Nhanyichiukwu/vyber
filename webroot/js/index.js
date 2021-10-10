/**
 * HorseSpeed - The PHP Web Application Framework for
 * 
 * @package HorseSpeed
 * @link https://www.horsespeed.org/ The HorseSpeed official website
 * @copyright (c) 2019, Scaling Horse Software, LLC
 * @author Nhanyichiukwu Hopeson Otuosorochiukwu
 * @license https://opensource.org/licenses/mit-license.php MIT License
 */


var app = require('express')();
var http = require('http').createServer(app);
var io = require('socket.io')(http);

app.get('/messages/t/', function (req, res) {
//    res.sendFile(__dirname + '/index.html');
});

io.on('connection', function(socket){
  console.log('a user connected');
  socket.on('disconnect', function(){
    console.log('user disconnected');
  });
  
  socket.on('chat message', function(msg){
    console.log('message: ' + msg);
    io.emit('chat message', msg);
  });
});

http.listen(3000, function () {
    console.log('Listening on *:3000');
});

