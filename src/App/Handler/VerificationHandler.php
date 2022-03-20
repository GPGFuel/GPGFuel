<?php

declare(strict_types=1);

namespace App\Handler;
use App\Services\StorageService;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function time;

class VerificationHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $fingerprint = $request->getAttribute('fingerprint');
        $signature = $request->getAttribute('signature');
        $storageService = new StorageService();

        try {
            $storageService->verifySignature($fingerprint, $signature);
            $storageService->setVerified($fingerprint);
            return new TextResponse(
                "You are now verified !",
                200,
            );
        } catch (\Exception $e) {
            return new TextResponse(
                "An error occured",
                500,
            );
        }
    }
}
