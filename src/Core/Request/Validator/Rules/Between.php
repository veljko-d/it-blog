<?php

namespace App\Core\Request\Validator\Rules;

/**
 * Class Between
 *
 * @package App\Core\Request\Validator\Rules
 */
class Between implements RuleInterface
{
    /**
     * @param array $data
     *
     * @return mixed|string
     */
    public function check(array $data)
    {
        $values = explode(',', $data['value']);
        $length = (strlen($data['input']));

        if ($length < $values[0] || $length > $values[1]) {
            return "{$data['field']} must have value within range "
                . "{$values[0]} and {$values[1]}.";
        }
    }
}
