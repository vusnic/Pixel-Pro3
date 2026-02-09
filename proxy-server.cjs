const http = require('http');
const httpProxy = require('http-proxy');

const proxy = httpProxy.createProxyServer({
  target: 'http://localhost:5173',
  ws: true,
  changeOrigin: true
});

proxy.on('error', function (err, req, res) {
  console.log('Proxy error:', err);
  if (res && !res.headersSent) {
    res.writeHead(500, { 'Content-Type': 'text/plain' });
    res.end('Proxy error: ' + err.message);
  }
});

const server = http.createServer(function(req, res) {
  proxy.web(req, res);
});

server.on('upgrade', function (req, socket, head) {
  proxy.ws(req, socket, head);
});

const PORT = process.env.PORT || 3000;
server.listen(PORT, '0.0.0.0', function() {
  console.log(`Proxy server running on port ${PORT}`);
  console.log(`Forwarding to http://localhost:5173`);
});
