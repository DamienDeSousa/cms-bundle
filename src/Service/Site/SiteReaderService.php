<?php

/**
 * File that defines the Site reader service class. This class is used to read a site.
 * Site must be unique.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Service\Site;

use Dades\CmsBundle\Entity\Site;
use Dades\CmsBundle\Repository\SiteRepository;

class SiteReaderService implements SiteReaderInterface
{
    public function __construct(private SiteRepository $siteRepository)
    {
    }

    public function read(): ?Site
    {
        $uniqueSite = null;
        $sites = $this->siteRepository->findAll();
        foreach ($sites as $site) {
            $uniqueSite = $site;
            break;
        }

        return $uniqueSite;
    }
}
