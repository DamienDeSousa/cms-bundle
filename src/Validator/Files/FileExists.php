<?php

/**
 * File that define the FileExists constraint class.
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Validator\Files;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class FileExists extends Constraint
{
    public string $message = 'file_exists';

    public string $file;

    public function getTargets(): array|string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
