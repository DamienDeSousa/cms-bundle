<?php

declare(strict_types=1);

namespace Dades\CmsBundle\Entity;

class BlankPage extends Page
{
    private ?int $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
