<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Utilities\KeyManager;

return $authMiddleware = function (Request $request, Response $response, $next) {
  $keyManager = new KeyManager(__DIR__ . "/../../keys.json");

  $key = $request->getHeaderLine('X-API-Key');
  $secret = $request->getHeaderLine('X-API-Secret');

  $client = $keyManager->validateKey($key, $secret);

  if ($client) {
    $request = $request->withAttribute('client', $client);
    return $next($request, $response);
  } else {
    return $response->withStatus(401)->withJson(['error' => 'Unauthorized']);
  }
};
