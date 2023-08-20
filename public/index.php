<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Utilities\Mailer;
use Handlers\NotFoundHandler;
use Validators\ParamsValidator;

require '../vendor/autoload.php';
$authMiddleware = require '../src/Middlewares/Authentication.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/..');
$dotenv->load();

$app = new \Slim\App;

// Handle undefined routes
$container = $app->getContainer();
$container['notFoundHandler'] = function () {
  return new NotFoundHandler();
};

$app->post('/sendmail', function (Request $request, Response $response) {
  $data = $request->getParsedBody();

  $validationResult = ParamsValidator::validate($data);

  if ($validationResult['status'] !== 'valid')
    return $response->withStatus($validationResult['status'])->withJson(['error' => $validationResult['message']]);

  $to = $data['to'];
  $subject = $data['subject'];
  // Check for text or html. Use null if not provided.
  $text = $data['text'] ?? null;
  $html = $data['html'] ?? null;

  $client = $request->getAttribute('client');

  if (Mailer::sendEmail($client, $to, $subject, $text, $html))
    return $response->withStatus(200)->withJson(['message' => 'Message has been sent']);
  else
    return $response->withStatus(500)->withJson(['error' => 'Message could not be sent.']);
})->add($authMiddleware);

$app->run();
