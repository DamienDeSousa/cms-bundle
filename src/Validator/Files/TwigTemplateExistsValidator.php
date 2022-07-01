<?php

namespace Dades\CmsBundle\Validator\Files;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Symfony\Contracts\Translation\TranslatorInterface;

class TwigTemplateExistsValidator extends ConstraintValidator
{
    public function __construct(private Environment $twig, private TranslatorInterface $translator)
    {

    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof TwigTemplateExists) {
            throw new UnexpectedTypeException($constraint, TwigTemplateExists::class);
        }

        if (!is_string($value)) {
            return;
        }

        try {
            $this->twig->load($value);
        } catch (LoaderError $exception) {
            $this->context
                ->buildViolation(
                    $this->translator->trans(
                        $constraint->message,
                        ['template_path' => $value],
                        'validators'
                    )
                )->addViolation();
        } catch (\Exception $exception) {
            $this->context
                ->buildViolation(
                    $this->translator->trans(
                        $constraint->unexpectedMessage,
                        ['template_path' => $value],
                        'validators'
                    )
                )->addViolation();
        }

    }
}