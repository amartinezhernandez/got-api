<?php

namespace App\Infrastructure\Exception;

use Exception;

class ExceptionHandlerService
{
    public $exceptionList;
    private $defaultMessage;

    private const DEFAULT_MSG = 'There was an error processing your request';

    public function __construct(
        array $exceptionList,
        string $defaultMessage = self::DEFAULT_MSG
    ) {
        $this->exceptionList = $exceptionList;
        $this->defaultMessage = $defaultMessage;
    }

    public function translate(Exception $e): string
    {
        $exceptionClass = get_class($e);
        return $this->exceptionList[$exceptionClass] ?? $this->defaultMessage;
    }
}
