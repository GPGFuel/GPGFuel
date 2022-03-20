<?php

declare(strict_types=1);

namespace App\Handler;

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

        return new HtmlResponse($this->template->render('app::received', ['users' => $users]));
    }
}
