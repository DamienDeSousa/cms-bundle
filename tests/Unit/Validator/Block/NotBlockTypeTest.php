<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Unit\Validator\Block;

use Dades\CmsBundle\Entity\Block;
use Dades\CmsBundle\Validator\Block\NotBlockType;
use Dades\CmsBundle\Validator\Block\NotBlockTypeValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class NotBlockTypeTest extends ConstraintValidatorTestCase
{
    protected function createValidator()
    {
        return new NotBlockTypeValidator();
    }

    public function testBlockWithSameType()
    {
        $block = new Block();
        $block->setType('seo_type');
        $block->setName('a name');
        $this->validator->validate($block, new NotBlockType(['type' => 'seo_type']));

        $this->assertEquals(1, count($this->context->getViolations()));
    }

    public function testBlockWithDifferentType()
    {
        $block = new Block();
        $block->setType('another_type');
        $block->setName('a name');
        $this->validator->validate($block, new NotBlockType(['type' => 'seo_type']));

        $this->assertNoViolation();
    }
}
