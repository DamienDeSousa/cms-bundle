<?php

/**
 * File that defines the BlockType class entity. This entity represent a block type.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JetBrains\PhpStorm\Pure;
use Doctrine\Common\Collections\Collection;

class BlockType
{
    private ?int $id;

    private ?string $type;

    private ?string $layout;

    private Collection $pageTemplateBlockTypes;

    private ?string $formType;

    #[Pure]
    public function __construct()
    {
        $this->pageTemplateBlockTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPageTemplateBlockTypes(): Collection
    {
        return $this->pageTemplateBlockTypes;
    }

    public function addPageTemplateBlockType(PageTemplateBlockType $pageTemplateBlockType): self
    {
        $this->pageTemplateBlockTypes->add($pageTemplateBlockType);

        return $this;
    }

    public function removePageTemplateBlockType(PageTemplateBlockType $pageTemplateBlockType): self
    {
        if ($this->pageTemplateBlockTypes->contains($pageTemplateBlockType)) {
            $this->pageTemplateBlockTypes->removeElement($pageTemplateBlockType);
        }

        return $this;
    }

    public function getLayout(): ?string
    {
        return $this->layout;
    }

    public function setLayout(?string $layout): self
    {
        $this->layout = $layout;

        return $this;
    }

    public function getFormType(): ?string
    {
        return $this->formType;
    }

    public function setFormType(?string $formType): self
    {
        $this->formType = $formType;

        return $this;
    }

    public function __toString(): string
    {
        return $this->type;
    }
}
