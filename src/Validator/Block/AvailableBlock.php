<?php

/**
 * Defines the AvailableBlock class.
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Validator\Block;

use Symfony\Component\Validator\Constraint;
use Dades\CmsBundle\Entity\Page;

class AvailableBlock extends Constraint
{
    public string $message = 'cms.available_block';

    public ?Page $page;

    public function getTargets(): array|string
    {
        return self::PROPERTY_CONSTRAINT;
    }

    public function __construct($options = null, array $groups = null, $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->page = $options['page'] ?? null;
    }
}