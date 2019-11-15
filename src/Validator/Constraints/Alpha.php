<?php


namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * Class Name
 * @package App\Validator\Constraints
 */
class Alpha extends Constraint
{
    public $message = 'Only alphabetical characters are allowed';

    public function validateBy()
    {
        return \get_class($this) . 'Validator';
    }
}