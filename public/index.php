<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Utilities\Mailer;
use Handlers\NotFoundHandler;

require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/..');
$dotenv->load();

$app = new \Slim\App;

// Handle undefined routes
$container = $app->getContainer();
$container['notFoundHandler'] = function ($container) {
  return new NotFoundHandler();
};

$app->post('/sendEmail', function (Request $request, Response $response) {
  $params = $request->getParsedBody();
  $to = $params['to'];
  $subject = $params['subject'];
  $text = $params['text'];
  $html = $params['html'];

  if (Mailer::sendEmail($to, $subject, $text, $html)) {
    return $response->withStatus(200)->withJson(['message' => 'Message has been sent']);
  } else {
    return $response->withStatus(500)->withJson(['error' => 'Message could not be sent.']);
  }
});

$app->run();
