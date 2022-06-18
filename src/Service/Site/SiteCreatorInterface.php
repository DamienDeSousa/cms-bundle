<?php

namespace Dades\CmsBundle\Service\Site;

use Dades\CmsBundle\Entity\Site;

interface SiteCreatorInterface
{
    public function create(string $title, string $icon = null): ?Site;
}
