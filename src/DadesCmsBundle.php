<?php

/**
 * File that defines the DadesCmsBundle class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle;

use Dades\CmsBundle\DependencyInjection\DadesCmsExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Defines the bundle.
 */
class DadesCmsBundle extends Bundle
{
    public function getContainerExtension(): ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new DadesCmsExtension();
        }

        return $this->extension;
    }
}
