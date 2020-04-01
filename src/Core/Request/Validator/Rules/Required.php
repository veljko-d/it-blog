<?php

namespace App\Core\Request\Validator\Rules;

use App\Core\Request\Validator\Rule;

/**
 * Class Required
 *
 * @package App\Core\Request\Validator\Rules
 */
class Required
{
    /**
     * @param string $field
     * @param array  $rules
     * @param        $input
     *
     * @return int|string
     */
    public function check(string $field, array $rules, $input)
    {
        $defined = array_key_exists(Rule::REQUIRED, $rules);
        $value = $rules[Rule::REQUIRED] ?? null;
        $empty = empty($input);

        if ((!$defined && $empty) || ($defined && $value === false && $empty)) {
            return false;
        } elseif ($defined && $value === true && empty($input)) {
            return "{$field} can't be empty.";
        }
    }
}
