<?php

namespace App\Presenters;

use Nette;
use Nette\Application\Responses;
use Tracy\ILogger;

/**
 * Error presenter
 */
class ErrorPresenter implements Nette\Application\IPresenter
{
    use Nette\SmartObject;

  /** @var ILogger */
    private $logger;

    /**
     * ErrorPresenter constructor
     *
     * @param ILogger $logger
     */
    public function __construct(ILogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * run
     *
     * @param Nette\Application\Request $request
     * @return Nette\Application\Response
     */
    public function run(Nette\Application\Request $request): Nette\Application\Response
    {
        $exception = $request->getParameter('exception');

        if ($exception instanceof Nette\Application\BadRequestException) {
            return new Responses\ForwardResponse($request->setPresenterName('Error4xx'));
        }

        $this->logger->log($exception, ILogger::EXCEPTION);
        return new Responses\CallbackResponse(function () {
            require __DIR__ . '/templates/Error/500.phtml';
        });
    }
}
