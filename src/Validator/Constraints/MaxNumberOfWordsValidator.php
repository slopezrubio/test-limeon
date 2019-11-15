<?php


namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class MaxNumberOfWordsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof MaxNumberOfWords) {
            throw new UnexpectedTypeException($constraint, MaxNumberOfWords::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $words = explode(' ', $value);


        if (count($words) > $constraint->maxWords) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}