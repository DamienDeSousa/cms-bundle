<?php

/**
 * File that defines the PageTemplateRepository class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

 declare(strict_types=1);

namespace Dades\CmsBundle\Repository\Structure;

use Dades\CmsBundle\Entity\PageTemplate;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * This class is used to query page template entity.
 *
 * @method PageTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageTemplate[]    findAll()
 * @method PageTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageTemplate::class);
    }
}
