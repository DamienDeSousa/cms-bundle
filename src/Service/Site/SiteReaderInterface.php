<?php

/**
 * Defines SiteReaderInterface interface.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Service\Site;

use Dades\CmsBundle\Entity\Site;

/**
 * Provide a method to read a Site entity.
 */
interface SiteReaderInterface
{
    /**
     * Return the unique Site entity if exists.
     *
     * @return Site|null
     */
    public function read(): ?Site;
}
