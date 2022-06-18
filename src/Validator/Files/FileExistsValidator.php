<?php

/**
 * File that defines the FileExistsValidator validator class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace Dades\CmsBundle\Validator\Files;

use Dades\EasyAdminExtensionBundle\Controller\Admin\BlockType\BlockTypeCRUDController;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class used to validate if a file exists.
 */
class FileExistsValidator extends ConstraintValidator
{
    public function __construct(
        private Filesystem $filesystem,
        private TranslatorInterface $translator,
    ) {
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof FileExists) {
            throw new UnexpectedTypeException($constraint, FileExists::class);
        }

        $file = __DIR__ . '/../../../../' . BlockTypeCRUDController::FORM_TYPE_BLOCK_RELATIVE_PATH . '/' . $value;
        if (
            !$value
            || !$this->filesystem->exists(
                $file
            )
        ) {
            $this->context
                ->buildViolation($this->translator->trans($constraint->message, ['file' => $file]))
                ->addViolation();
        }
    }
}
