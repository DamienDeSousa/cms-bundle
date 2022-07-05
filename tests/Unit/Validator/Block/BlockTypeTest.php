<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Unit\Validator\Block;

use Dades\CmsBundle\Entity\Block;
use Dades\CmsBundle\Validator\Block\BlockType;
use Dades\CmsBundle\Validator\Block\BlockTypeValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class BlockTypeTest extends ConstraintValidatorTestCase
{
    protected function createValidator()
    {
        return new BlockTypeValidator();
    }

    public function testBlockWithRightType()
    {
        $block = new Block();
        $block->setType('seo_type');
        $this->validator->validate($block, new BlockType(['type' => 'seo_type']));

        $this->assertNoViolation();
    }

    public function testBlockTypeWithWrongType()
    {
        $block = new Block();
        $block->setType('wrong_type');
        $block->setName('a name');
        $this->validator->validate($block, new BlockType(['type' => 'seo_type']));

        $this->assertEquals(1, count($this->context->getViolations()));
    }
}