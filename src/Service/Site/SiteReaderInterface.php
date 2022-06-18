<?php

namespace Dades\CmsBundle\Service\Site;

use Dades\CmsBundle\Entity\Site;

interface SiteReaderInterface
{
    public function read(): ?Site;
}
