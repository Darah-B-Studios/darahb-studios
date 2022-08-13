const WebSocketServer = require('websocket').server;
const http = require('http');
const htmlEntity = require('html-entities');
const PORT = 5000;

// list of known clients of the app
const clients = [];

// Create http server
const server = http.createServer();

server.listen(PORT, () => console.log(`server started at port ${PORT}`));

// Create websockete server
const ws = new WebSocketServer({
    httpServer: server
});

ws.on("request", (req) => {
    const connection = req.accept(null, req.origin);
    const index = clients.push(connection) - 1;

    console.log('Client', index, "connected");
    connection.on("message", (message) => {
        // @ts-ignore
        const data = JSON.parse(message.utf8Data);
        if (message.type === 'utf8') {
            // prepare and send json dat to all connected clients
            const resData = JSON.stringify({
                title: htmlEntity.encode(data.title),
                message: htmlEntity.encode(data.message)
            });

            clients.forEach(client => client.sendUTF(resData));
        }
    });

    /**
     * Run when the client disconnects from the app
     */
    connection.on('close', () => {
        clients.splice(index, 1);
        console.log("client ", index, " was disconnected");
    });

});