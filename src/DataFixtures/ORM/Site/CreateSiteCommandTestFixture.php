<?php

/**
 * File that defines the create site command test fixture.
 * This class is used to completely flushes the database for tests.
 *
 * @author Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\DataFixtures\ORM\Site;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CreateSiteCommandTestFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
    }
}
