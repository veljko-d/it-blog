<?php

namespace App\Core\Request\Validator\Rules;

/**
 * Class Max
 *
 * @package App\Core\Request\Validator\Rules
 */
class Max implements RuleInterface
{
    /**
     * @param array $data
     *
     * @return mixed|string
     */
    public function check(array $data)
    {
        $length = (strlen($data['input']));

        if ($length > $data['value']) {
            return "{$data['field']} is too long, maximum length is "
                . "{$data['value']} characters.";
        }
    }
}
