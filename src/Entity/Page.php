<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Entity;

abstract class Page
{
    private ?SEOBlock $SEOBlock;

    private ?string $template;

    public function getSEOBlock(): ?SEOBlock
    {
        return $this->SEOBlock;
    }

    public function setSEOBlock(?SEOBlock $SEOBlock): void
    {
        $this->SEOBlock = $SEOBlock;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): void
    {
        $this->template = $template;
    }
}