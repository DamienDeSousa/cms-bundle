<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Functional\Controller;

use Dades\CmsBundle\DataFixtures\ORM\Controller\PageControllerTestFixture;
use Dades\CmsBundle\Entity\Page;
use Dades\TestFixtures\Fixture\FixtureAttachedTrait;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    use FixtureAttachedTrait;

    private KernelBrowser $client;

    protected static function getFixtureNameForTestCase(string $testCaseName): string
    {
        return PageControllerTestFixture::class;
    }

    protected function setUp(): void
    {
        if (!$this instanceof KernelTestCase) {
            throw new LogicException(
                'The "FixtureAttachedTrait" should only be used on objects extending the '
                . 'symfony/framework-bundle KernelTestCase.'
            );
        }

        //star rewrite
        $this->client = static::createClient();
        //end rewrite

        if (!self::$container->has(ManagerRegistry::class)) {
            throw new LogicException(
                'No Doctrine ManagerRegistry service has been found in the service container. Please provide'
                . 'an implementation.'
            );
        }

        /** @var ManagerRegistry $registry */
        $registry = self::$container->get(ManagerRegistry::class);
        $fixtureName = static::getFixtureNameForTestCase(get_class($this));
        $this->loadFixture(
            $registry->getManager(),
            new $fixtureName()
        );
    }

    public function testDisplayCmsPage()
    {
        /** @var Page $page */
        $page = $this->fixtureRepository->getReference('page');
        $this->client->request('GET', sprintf('/%s', $page->getUrl()));

        $this->assertResponseIsSuccessful();
    }

    public function testDisplay404CmsPage()
    {
        $this->client->request('GET', '/unexpected-url');

        $this->assertResponseStatusCodeSame(404);
    }
}