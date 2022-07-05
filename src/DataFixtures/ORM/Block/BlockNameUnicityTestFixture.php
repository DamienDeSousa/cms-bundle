<?php

/**
 * Defines BlockNameUnicityTestFixture class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\DataFixtures\ORM\Block;

use Dades\CmsBundle\Entity\Block;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Provides data for test.
 */
class BlockNameUnicityTestFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $block = new Block();
        $block->setType('empty_block');
        $block->setName('Empty Block');
        $block->setTemplate('path/to/template.html.twig');
        $manager->persist($block);
        $manager->flush();
        $this->addReference('block', $block);
    }
}