<?php

/**
 * Defines the AvailableBlockValidator class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Validator\Block;

use Dades\CmsBundle\Entity\Block;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Validates if a Block is available to be linked to a Page.
 */
class AvailableBlockValidator extends ConstraintValidator
{
    public function __construct(private TranslatorInterface $translator)
    {

    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof AvailableBlock) {
            throw new UnexpectedTypeException($constraint, AvailableBlock::class);
        }

        if (!$value instanceof Block) {
            return;
        }

        $relatedPage = $value->getPageForSeo();

        if ($relatedPage && $relatedPage->getId() !== $constraint->page->getId()) {
            $this->context
                ->buildViolation(
                    $this->translator->trans(
                        $constraint->message,
                        ['block_name' => $value->getName()],
                        'validators'
                    )
                )->addViolation();
        }
    }
}