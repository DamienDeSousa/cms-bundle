<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Entity;

class SEOBlock
{
    //https://www.crodde.com/blog/balises-seo-html/

    private ?int $id;

    private ?string $title;

    private ?string $description;

    private ?array $metaRobots;

    private ?string $metaViewport;

    private ?string $canonical;

    private ?string $template;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getMetaRobots(): ?array
    {
        return $this->metaRobots;
    }

    public function setMetaRobots(?array $metaRobots): void
    {
        $this->metaRobots = $metaRobots;
    }

    public function getMetaViewport(): ?string
    {
        return $this->metaViewport;
    }

    public function setMetaViewport(?string $metaViewport): void
    {
        $this->metaViewport = $metaViewport;
    }

    public function getCanonical(): ?string
    {
        return $this->canonical;
    }

    public function setCanonical(?string $canonical): void
    {
        $this->canonical = $canonical;
    }

    public function getId(): ?int
    {
        return $this->id;
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
