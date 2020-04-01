<?php

namespace App\Core\Request\Validator\Rules\Types;

/**
 * Class Alphabetic
 *
 * @package App\Core\Request\Validator\Rules\Types
 */
class Alphabetic implements TypeInterface
{
    /**
     * @param array $data
     *
     * @return mixed|string
     */
    public function check(array $data)
    {
        if (!ctype_alpha($data['input'])) {
            return "{$data['field']} must be entirely alphabetic";
        }
    }
}
