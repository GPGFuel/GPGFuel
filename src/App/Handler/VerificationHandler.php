<?php

declare(strict_types=1);

namespace App\Handler;
use App\Services\StorageService;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\TextResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


class VerificationHandler implements RequestHandlerInterface
{
    /** @var null|TemplateRendererInterface */
    private $template;

    public function __construct(TemplateRendererInterface $template = null)
    {
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $fingerprint = $request->getAttribute('fingerprint');
        $signature = $request->getAttribute('signature');
        $storageService = new StorageService();

        try {
            $storageService->verifySignature($fingerprint, $signature);
            $storageService->setVerified($fingerprint);
            return new HtmlResponse($this->template->render('app::verified', []));

        } catch (\Exception $e) {
            return new TextResponse(
                "An error occured",
                500,
            );
        }
    }
}
