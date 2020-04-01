<?php

namespace App\Core\Request\Validator\Rules;

/**
 * Class Same
 *
 * @package App\Core\Request\Validator\Rules
 */
class Same implements RuleInterface
{
    /**
     * @param array $data
     *
     * @return mixed|string
     */
    public function check(array $data)
    {
        $fieldToCompare = ucwords(str_replace('_', ' ', $data['value']));;
        $valueToCompare = ($data['inputs'][$data['value']]);

        if ($data['input'] !== $valueToCompare) {
            return "{$data['field']} and $fieldToCompare must match.";
        }
    }
}
