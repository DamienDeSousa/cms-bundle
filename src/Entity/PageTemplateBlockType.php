<?php

/**
 * File that defines the PageTemplateBlockType entity.
 * This entity make this link between a page template entity and a block type entity.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Entity;

class PageTemplateBlockType
{
    private ?int $id;

    private ?string $slug;

    private ?PageTemplate $pageTemplate;

    private ?BlockType $blockType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPageTemplate(): ?PageTemplate
    {
        return $this->pageTemplate;
    }

    public function setPageTemplate(?PageTemplate $pageTemplate): self
    {
        $this->pageTemplate = $pageTemplate;

        return $this;
    }

    public function getBlockType(): ?BlockType
    {
        return $this->blockType;
    }

    public function setBlockType(?BlockType $blockType): self
    {
        $this->blockType = $blockType;

        return $this;
    }
}
