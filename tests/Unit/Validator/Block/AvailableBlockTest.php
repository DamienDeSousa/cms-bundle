<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Unit\Validator\Block;

use Dades\CmsBundle\Entity\Block;
use Dades\CmsBundle\Entity\Page;
use Dades\CmsBundle\Validator\Block\AvailableBlock;
use Dades\CmsBundle\Validator\Block\AvailableBlockValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

class AvailableBlockTest extends ConstraintValidatorTestCase
{
    private Page $page;

    protected function createValidator()
    {
        return new AvailableBlockValidator();
    }

    protected function setUp(): void
    {
        $this->page = new Page();

        parent::setUp();
    }

    public function testBlockWithoutLinkedPageIsAvailable()
    {
        $block = new Block();
        $block->setPageForSeo(null);
        $this->validator->validate($block, new AvailableBlock(['page' => $this->page]));


        $this->assertNoViolation();
    }

    public function testBlockWithLinkedPageIsAvailable()
    {
        $block = new Block();
        $block->setPageForSeo($this->page);
        $this->validator->validate($block, new AvailableBlock(['page' => $this->page]));

        $this->assertNoViolation();
    }

    public function testBlockIsNotAvailable()
    {
        $block = new Block();
        $block->setName('block name');
        $page = new Page();
        $block->setPageForSeo($page);
        $this->validator->validate($block, new AvailableBlock(['page' => $this->page]));

        $this->assertEquals(1, count($this->context->getViolations()));
    }
}