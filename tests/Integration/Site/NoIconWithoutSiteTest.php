<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Site;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NoIconWithoutSiteTest extends KernelTestCase
{
    private \Twig\Environment $twig;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->twig = self::$kernel->getContainer()->get('test.service_container')->get('twig');
    }

    public function testGetEmptyIconWithoutSite()
    {
        $twigGetIconFunction = $this->twig->getFunction('get_icon');
        $getIcon = $twigGetIconFunction->getCallable();

        $this->assertNull($getIcon());
    }
}
