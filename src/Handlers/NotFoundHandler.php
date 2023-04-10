<?php

namespace Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotFoundHandler
{
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
  {
    return $response
      ->withStatus(404)
      ->withJson(['error' => 'Route not found']);
  }
}
