<?php

namespace App\Core\Request\Validator\Rules;

/**
 * Class Min
 *
 * @package App\Core\Request\Validator\Rules
 */
class Min implements RuleInterface
{
    /**
     * @param array $data
     *
     * @return mixed|string
     */
    public function check(array $data)
    {
        $length = (strlen($data['input']));

        if ($length < $data['value']) {
            return "{$data['field']} is too short, minimum length is "
                . "{$data['value']} characters.";
        }
    }
}
