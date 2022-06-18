<?php

/**
 * File that defines the BlockTypeRepository class.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Repository\Structure;

use Dades\CmsBundle\Entity\BlockType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method BlockType|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlockType|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlockType[]    findAll()
 * @method BlockType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlockTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlockType::class);
    }
}
