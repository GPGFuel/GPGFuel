<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PublishHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
      $body = $request->getParsedBody();
      if (!isset($body['pgp-key']) || !$body['pgp-key']) {
        return new EmptyResponse(400);
      }

      $key = $body['pgp-key'];
      $pubKey = \OpenPGP_Message::parse(\OpenPGP::unarmor($key));

      // For now, only list all user ids found in the key
      $users = [];
      foreach ($pubKey as $packet) {
        if ($packet instanceof \OpenPGP_UserIDPacket) {
          $users[] = $packet;
        }
      }

      return new JsonResponse($users);
    }
}
