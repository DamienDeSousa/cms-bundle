<?php

/**
 * File that defines the TranslateException abstract class.
 *
 * @author Damien DE SOUSA
 * @copyright 2022
 */

namespace Dades\CmsBundle\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

/**
 * Exception class used to provide translatable message with optionnal parameters.
 */
abstract class TranslateException extends Exception
{
    #[Pure]
    public function __construct(
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    abstract public function getTransMessage(): string;

    /**
     * Returns parameters usefull for the translatable message.
     * If there is not parameter, just return an empty array.
     *
     * @return array
     */
    abstract public function getTransMessageParams(): array;
}
