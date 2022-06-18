<?php

/**
 * File that defines the Site creater service class. This class is used to create a site.
 * Site must be unique.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Service\Site;

use Dades\CmsBundle\Entity\Site;
use Dades\CmsBundle\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class SiteCreatorHelper implements SiteCreatorInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private SiteRepository $siteRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function create(string $title, string $icon = null): ?Site
    {
        //test if a site already exists
        $sites = $this->siteRepository->findAll();
        $site = null;

        if (!$sites) {
            $site = new Site();
            $site->setTitle($title);
            $site->setIcon($icon);
            $this->entityManager->persist($site);
            $this->entityManager->flush();
        }

        if ($sites) {
            $this->logger->warning('Site entity ["' . $title . '"] already exists, must be unique');
        }

        return $site;
    }
}
