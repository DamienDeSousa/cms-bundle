<?php

/**
 * Define the Twig admin extensions.
 *
 * @author    Damien DE SOUSA <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Twig\Admin;

use Dades\CmsBundle\Service\Site\SiteReaderInterface;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class AdminExtension extends AbstractExtension
{
    private const DEFAULT_TITLE = 'Symfony CMS';

    public function __construct(private SiteReaderInterface $siteReaderService, private string $iconDirectory)
    {
    }

    /**
     * @inheritDoc
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_title', [$this, 'getTitle']),
            new TwigFunction('get_icon', [$this, 'getIcon']),
        ];
    }

    public function getTitle(): string
    {
        $title = static::DEFAULT_TITLE;
        $site = $this->siteReaderService->read();
        if ($site && $site->getTitle()) {
            $title = $site->getTitle();
        }

        return $title;
    }

    public function getIcon(): ?string
    {
        $path = null;
        $icon = null;
        $site = $this->siteReaderService->read();
        if ($site && $site->getIcon()) {
            $icon = $site->getIcon();
            $path = $this->iconDirectory . $icon;
        }

        return $path;
    }
}
