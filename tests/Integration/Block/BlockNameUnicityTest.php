<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Block;

use Dades\CmsBundle\DadesCmsBundle;
use Dades\CmsBundle\Tests\Integration\Block\BlockNameUnicityTestFixture;
use Dades\CmsBundle\Entity\Block;
use Dades\TestUtils\Loader\LoadResourceTrait;
use Dades\CmsBundle\Tests\RunCommandTrait;
use Dades\TestFixtures\Fixture\FixtureLoaderTrait;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Routing\RouteCollectionBuilder;

class BlockNameUnicityTest extends TestCase
{
    use FixtureLoaderTrait;

    use RunCommandTrait;

    private ManagerRegistry $managerRegistry;

    public function testUnableToCreateBlockWithSameName()
    {
        $this->expectException(\Doctrine\DBAL\Exception\UniqueConstraintViolationException::class);
        /** @var Block $block */
        $block = $this->fixtureRepository->getReference('block');
        $newBlock = new Block();
        $newBlock->setTemplate($block->getTemplate());
        $newBlock->setType($block->getType());
        $newBlock->setName($block->getName());
        $this->managerRegistry->getManager()->persist($newBlock);
        $this->managerRegistry->getManager()->flush();
    }

    protected function setUp(): void
    {
        $kernel = new class('test', true) extends Kernel
        {
            use MicroKernelTrait;

            use LoadResourceTrait;

            public function __construct(string $environment, bool $debug)
            {
                parent::__construct($environment, $debug);
            }

            public function registerBundles(): iterable
            {
                return [
                    new DadesCmsBundle(),
                    new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
                    new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
                    new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
                    new \Symfony\Bundle\TwigBundle\TwigBundle(),
                ];
            }

            protected function configureRoutes(RouteCollectionBuilder $routes)
            {
            }

            protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
            {
                $confDir = $this->getProjectDir().'/tests/fixtures/resources/config';
                $this->loadDoctrineResource($this->getProjectDir(), $loader);
                $this->loadFrameworkResource($this->getProjectDir(), $loader);
                $this->loadTwigResource($this->getProjectDir(), $loader);
            }

            public function getCacheDir(): string
            {
                return __DIR__ . '/../../../cache/' . spl_object_hash($this);
            }
        };

        $kernel->boot();
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $this->runCommand(
            $application,
            [
                'command' => 'doctrine:schema:update',
                '--quiet' => true,
                '--force' => true,
            ]
        );
        $this->managerRegistry = $kernel->getContainer()->get('doctrine');
        $this->loadFixture(
            $this->managerRegistry->getManager(),
            new BlockNameUnicityTestFixture()
        );
    }
}
