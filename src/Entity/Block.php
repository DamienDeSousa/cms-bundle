<?php

/**
 * Defines the Block class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Entity;

/**
 * Represents a block in database.
 */
class Block
{
    private ?int $id;

    private ?string $name;

    private ?string $template;

    private ?array $content;

    private ?string $type;

    private ?Page $pageForSeo;

    private  ?Page $page;

    public function __construct()
    {
        $this->content = [];
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): void
    {
        $this->page = $page;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): void
    {
        $this->template = $template;
    }

    public function getContent(): ?array
    {
        return $this->content;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getPageForSeo(): ?Page
    {
        return $this->pageForSeo;
    }

    public function setPageForSeo(?Page $pageForSeo): void
    {
        $this->pageForSeo = $pageForSeo;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function __call(string $name , array $arguments)
    {
        $methods = get_class_methods($this);
        if (in_array($name, $methods)) {
            return $this->$name($arguments);
        } elseif (str_starts_with($name, 'get')) {
            return $this->getProperty($name);
        } elseif (str_starts_with($name, 'set')) {
            $this->setProperty($name, $arguments);
        }
    }

    private function setProperty($name, $arguments): void
    {
        $extractedPropertyName = substr($name, 3);
        $property = lcfirst($extractedPropertyName);
        $this->content[$property] = reset($arguments);
    }

    private function getProperty(string $name): mixed
    {
        $extractedPropertyName = substr($name, 3);
        $property = lcfirst($extractedPropertyName);

        return $this->content[$property] ?? null;
    }
}
