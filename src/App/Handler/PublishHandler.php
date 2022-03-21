<?php

declare(strict_types=1);

namespace App\Handler;

use App\Services\MailService;
use App\Services\StorageService;
use App\Utilities;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PublishHandler implements RequestHandlerInterface
{
    /** @var null|TemplateRendererInterface */
    private $template;

    public function __construct(TemplateRendererInterface $template = null)
    {
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();
        if (!isset($body['pgp-key']) || !$body['pgp-key']) {
            return new EmptyResponse(400);
        }

        $key = $body['pgp-key'];
        $rawKey = \OpenPGP::unarmor($key);
        $pubKey = \OpenPGP_Message::parse($rawKey);

        // For now, only list all user ids found in the key
        $users = Utilities::getUniqueUsers($pubKey);
        
        $mailService = new MailService();
        $storageService = new StorageService();
        foreach($users as $user) {
            $fingerprint = Utilities::emailToWDKHash($user->email);
            $storageService->storePublicKey($fingerprint, $rawKey);
            $signature = $storageService->generateSignature($fingerprint);
            $verifyUrl = $_ENV['APP_URL']."/verify/$fingerprint/$signature";
            $mailService->sendMail($user->email, $user->name, 'Verify yourself', 'To verify yourself, click here : <a href="'.$verifyUrl.'">'.$verifyUrl.'</a>');
        }

        return new HtmlResponse($this->template->render('app::received', ['users' => $users]));
    }
}
