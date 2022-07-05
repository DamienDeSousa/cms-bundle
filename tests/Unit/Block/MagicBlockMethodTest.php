<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Unit\Block;

use Dades\CmsBundle\Entity\Block;

class MagicBlockMethodTest extends \PHPUnit\Framework\TestCase
{
    public function testMagicBlockMethod()
    {
        $block = new Block();
        //this call is magic and must work
        $block->setUnknownProperty('unknown_value');
        //this call is also magic and must work
        $unknownProperty = $block->getUnknownProperty();
        $content = $block->getContent();

        $this->assertEquals('unknown_value', $unknownProperty);
        $this->assertArrayHasKey('unknownProperty', $content);
        $this->assertEquals('unknown_value', $content['unknownProperty']);
    }
}