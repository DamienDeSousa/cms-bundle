<?php

/**
 * Defines the NotBlockType class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Validator\Block;

use Symfony\Component\Validator\Constraint;

/**
 * Set up constraint in order to validate it with the validator.
 */
class NotBlockType extends Constraint
{
    public string $message = 'cms.not_block_type';

    public string $type;

    public function getTargets(): array|string
    {
        return self::PROPERTY_CONSTRAINT;
    }

    public function __construct($options = null, array $groups = null, $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->type = $options['type'] ?? null;
    }
}