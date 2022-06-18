<?php

/**
 * File that defines the PageTemplateBlockTypeRepository class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

namespace Dades\CmsBundle\Repository\Structure;

use Doctrine\Persistence\ManagerRegistry;
use Dades\CmsBundle\Entity\PageTemplateBlockType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class used to request PageTemplateBlockType entity.
 *
 * @method PageTemplateBlockType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageTemplateBlockType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageTemplateBlockType[]    findAll()
 * @method PageTemplateBlockType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageTemplateBlockTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageTemplateBlockType::class);
    }
}
