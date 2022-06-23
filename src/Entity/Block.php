<?php

namespace Dades\CmsBundle\Entity;

abstract class Block
{
    private ?string $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
