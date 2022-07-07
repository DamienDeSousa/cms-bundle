<?php

/**
 * Defines PageControllerTestFixture class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Functional\Controller;

use Dades\CmsBundle\Entity\Block;
use Dades\CmsBundle\Entity\Page;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Provides data for test.
 */
class PageControllerTestFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $block = new Block();
        $block->setTemplate('@DadesCms/block/seo_block/seoblock.html.twig');
        $block->setName('SEO BLOCK');
        $block->setType('seo_block');
        $block->setTitle('Titre');
        $block->setDescription('Description');
        $block->setMetaRobots(['noindex', 'nofollow']);
        $block->setMetaViewport('viewport');

        $page = new Page();
        $page->setRouteName('route_name');
        $page->setTemplate('@DadesCms/page/blankpage/seo_page.html.twig');
        $page->setUrl('anakin-skywalker');
        $page->setSeoBlock($block);
        $manager->persist($page);
        $manager->flush();
        $this->addReference('page', $page);
    }
}