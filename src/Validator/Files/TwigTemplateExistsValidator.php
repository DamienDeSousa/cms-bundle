<?php

namespace Dades\CmsBundle\Validator\Files;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Symfony\Contracts\Translation\TranslatorInterface;

class TwigTemplateExistsValidator extends ConstraintValidator
{
    public function __construct(private Environment $twig)
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
            $this->addViolation($constraint->message, ['template_path' => $value]);
        } catch (\Exception $exception) {
            $this->addViolation($constraint->unexpectedMessage, ['template_path' => $value]);
        }
    }

    private function addViolation(string $message, array $parameters): void
    {
        $this->context
            ->buildViolation($message)
            ->setParameters($parameters)
            ->setTranslationDomain('validators')
            ->addViolation();
    }
}