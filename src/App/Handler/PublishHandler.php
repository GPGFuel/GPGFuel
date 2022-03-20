<?php

declare(strict_types=1);

namespace App\Handler;

use App\Services\MailService;
use App\Services\StorageService;
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
        $pubKey = \OpenPGP_Message::parse(\OpenPGP::unarmor($key));

        // For now, only list all user ids found in the key
        $users = [];
        foreach ($pubKey as $packet) {
            if ($packet instanceof \OpenPGP_UserIDPacket) {
                $users[] = $packet;
            }
        }

        $mailService = new MailService();
        $storageService = new StorageService();
        foreach($users as $user) {
            $keyContent = uniqid();
            $fingerprint = hash("sha256", $keyContent); // TODO : Replace with key / email fingerprint
            $storageService->storePublicKey($fingerprint, $keyContent);
            $signature = $storageService->generateSignature($fingerprint);
            $verifyUrl = $_ENV['APP_URL']."/verify/$fingerprint/$signature";
            $mailService->sendMail($user->email, $user->name, 'Verify yourself', 'To verify yourself, click here : <a href="'.$verifyUrl.'">'.$verifyUrl.'</a>');
        }

        return new HtmlResponse($this->template->render('app::received', ['users' => $users]));
    }
}
