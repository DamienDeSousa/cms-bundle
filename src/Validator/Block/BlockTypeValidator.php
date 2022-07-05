<?php

/**
 * Defines the BlockTypeValidator class.
 *
 * @author Damien DE SOUSA
 */

namespace Dades\CmsBundle\Validator\Block;

use Dades\CmsBundle\Entity\Block;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Validates if a Block type as the same type than the given type.
 */
class BlockTypeValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof BlockType) {
            throw new UnexpectedTypeException($constraint, BlockType::class);
        }
        
        if (!$value instanceof Block) {
            return;
        }
        
        if ($value->getType() !== $constraint->type) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameters(
                    [
                        'block_name' => $value->getName(),
                        'block_type' => $value->getType(),
                        'expected_type' => $constraint->type,
                    ]
                )->setTranslationDomain('validators')
                ->addViolation();
        }
    }
}