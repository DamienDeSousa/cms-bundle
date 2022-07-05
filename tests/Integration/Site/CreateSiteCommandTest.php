<?php

/**
 * File that defines the create site command test. This class is used to test the command which creates a new Site.
 * It also tests the impossibility of creating more than one Site.
 *
 * @author Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Site;

use Dades\CmsBundle\DataFixtures\ORM\Site\CreateSiteCommandTestFixture;
use Dades\TestFixtures\Fixture\FixtureAttachedTrait;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CreateSiteCommandTest extends KernelTestCase
{
    use FixtureAttachedTrait;

    protected static function getFixtureNameForTestCase(string $testCaseName): string
    {
        return CreateSiteCommandTestFixture::class;
    }

    public function testCreateSiteExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('cms:site:create');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'title' => 'site-test-title',
        ]);
        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('Site created successfully', $output);
    }

    public function testCreateMoreSiteExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('cms:site:create');
        $commandTester = new CommandTester($command);

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'title' => 'site-test-title',
        ]);
        $output = $commandTester->getDisplay();

        $commandTester->execute([
            'title' => 'site-test-title-2',
        ]);
        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('Can\'t create site, a site should already exist', $output);
    }
}
