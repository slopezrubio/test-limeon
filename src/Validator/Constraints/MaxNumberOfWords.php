<?php


namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * Class MaxNumberOfWords
 * @package App\Validator\Constraints
 */
class MaxNumberOfWords extends Constraint
{
    public $message = 'The text has surpassed the number of words allowed';
    public $maxWords = 1000;

    public function validateBy()
    {
        return \get_class($this). 'Validator';
    }
}