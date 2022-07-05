<?php

/**
 * Define the NotBlockTypeValidator class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Validator\Block;

use Dades\CmsBundle\Entity\Block;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Validate if a Block type is different than the given type.
 */
class NotBlockTypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof NotBlockType) {
            throw new UnexpectedTypeException($constraint, NotBlockType::class);
        }

        if ($value instanceof Collection) {
            foreach ($value as $block) {
                if ($block instanceof Block && $block->getType() === $constraint->type) {
                    $this->context
                        ->buildViolation($constraint->message)
                        ->setParameters(
                            [
                                'block_name' => $block->getName(),
                                'block_type' => $block->getType(),
                            ]
                        )->setTranslationDomain('validators')
                        ->addViolation();
                }
            }
        } elseif ($value instanceof Block) {
            if ($value instanceof Block && $value->getType() === $constraint->type) {
                $this->context
                    ->buildViolation($constraint->message)
                    ->setParameters(
                        [
                            'block_name' => $value->getName(),
                            'block_type' => $value->getType(),
                        ]
                    )->setTranslationDomain('validators')
                    ->addViolation();
            }
        }
    }
}
