<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use nicoSWD\GPG\GPG;
use nicoSWD\GPG\PublicKey;

use function time;

class PublishHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
      $body = $request->getParsedBody();
      if (!isset($body['pgp-key']) || !$body['pgp-key']) {
        return new EmptyResponse(400);
      }

      $key = $body['pgp-key'];
      $pubKey = new PublicKey($key);
      return new JsonResponse(['key' => $pubKey]);
    }
}
