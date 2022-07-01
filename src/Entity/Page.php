<?php

/**
 * Defines the Page class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Represents a page in database.
 */
class Page
{
    private ?int $id;

    private ?Block $seoBlock;

    private ?string $template;

    private ?string $routeName;

    private ?string $url;

    private Collection $blocks;

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
    }

    public function getBlocks(): ArrayCollection|Collection
    {
        return $this->blocks;
    }

    public function addBlock(?BLock $block): void
    {
        if ($block && !$this->blocks->contains($block)) {
            $block->setPage($this);
            $this->blocks->add($block);
        }
    }

    public function removeBlock(?Block $block): void
    {
        if ($block && $this->blocks->contains($block)) {
            $block->setPage(null);
            $this->blocks->removeElement($block);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeoBlock(): ?Block
    {
        return $this->seoBlock;
    }

    public function setSeoBlock(?Block $seoBlock): void
    {
        $this->seoBlock = $seoBlock;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): void
    {
        $this->template = $template;
    }

    public function getRouteName(): ?string
    {
        return $this->routeName;
    }

    public function setRouteName(?string $routeName): void
    {
        $this->routeName = $routeName;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }
}
