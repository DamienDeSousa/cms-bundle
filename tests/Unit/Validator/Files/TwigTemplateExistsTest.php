<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Tests\Unit\Validator\Files;

use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Twig\Environment;
use Twig\Error\LoaderError;

class TwigTemplateExistsTest extends ConstraintValidatorTestCase
{
    private Environment $twig;

    protected function setUp(): void
    {
        $this->twig = $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->getMock();
        parent::setUp();
    }

    protected function createValidator()
    {
        return new \Dades\CmsBundle\Validator\Files\TwigTemplateExistsValidator($this->twig);
    }

    public function testValidTwigTemplate()
    {
        $this->twig->method('load')->willReturn('');
        $this->validator->validate(
            '@DadesCms/page/blankpage/seo_page.html.twig',
            new \Dades\CmsBundle\Validator\Files\TwigTemplateExists()
        );

        $this->assertNoViolation();
    }

    public function testInvalidTwigTemplate()
    {
        $this->twig
            ->method('load')
            ->willThrowException(
                new LoaderError(
                    sprintf('Template "%s" is not defined.', 'wrong/path/to/template/seo_page.html.twig')
                )
            );
        $this->validator->validate(
            'wrong/path/to/template/seo_page.html.twig',
            new \Dades\CmsBundle\Validator\Files\TwigTemplateExists()
        );

        $this->assertEquals(1, count($this->context->getViolations()));
    }
}