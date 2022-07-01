<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Validator\Files;

use Symfony\Component\Validator\Constraint;

class TwigTemplateExists extends Constraint
{
    public string $message = 'cms.twig_template_exists';

    public string $unexpectedMessage = 'cms.unexpected_twig_template_exists';

    public function getTargets(): array|string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
