<?php

/**
 * Defines SiteCreatorInterface interface.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Service\Site;

use Dades\CmsBundle\Entity\Site;

/**
 * Provide method to create a Site entity.
 */
interface SiteCreatorInterface
{
    /**
     * Create a Site entity by giving a title and an icon.
     * The icon is the path to the file.
     *
     * @param string      $title
     * @param string|null $icon
     *
     * @return Site|null
     */
    public function create(string $title, string $icon = null): ?Site;
}
