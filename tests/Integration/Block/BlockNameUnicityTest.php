<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Integration\Block;

use Dades\CmsBundle\DataFixtures\ORM\Block\BlockNameUnicityTestFixture;
use Dades\CmsBundle\Entity\Block;
use Dades\TestFixtures\Fixture\FixtureAttachedTrait;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class BlockNameUnicityTest extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    use FixtureAttachedTrait {
        FixtureAttachedTrait::setUp as setUpTrait;
    }

    private ManagerRegistry $managerRegistry;

    protected static function getFixtureNameForTestCase(string $testCaseName): string
    {
        return BlockNameUnicityTestFixture::class;
    }

    protected function setUp(): void
    {
        $this->setUpTrait();
        self::bootKernel();
        $this->managerRegistry = self::$kernel->getContainer()->get('doctrine');
    }

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
}