<?php

/**
 * Defines the PageController class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Controller;

use Dades\CmsBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Returns CMS pages with their contents.
 */
class PageController extends AbstractController
{
    public function __construct(private ManagerRegistry $managerRegistry)
    {
    }

    public function __invoke(Request $request): Response
    {
        /** @var Page $page */
        $page = $this->managerRegistry
            ->getRepository(Page::class)
            ->findOneBy(
                ['url' => substr($request->getRequestUri(), 1)]
            );
        if (!$page) {
            throw new NotFoundHttpException();
        }

        return $this->render(
            $page->getTemplate(),
            [
                'seoBlock' => $page->getSeoBlock(),
                'blocks' => $page->getBlocks()
            ]
        );
    }
}
