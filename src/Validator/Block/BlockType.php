<?php

/**
 * Defines the BlockType class.
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Validator\Block;

use Symfony\Component\Validator\Constraint;

class BlockType extends Constraint
{
    public string $message = 'cms.block_type';
    
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