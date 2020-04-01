<?php

namespace App\Core\Request\Validator\Rules;

/**
 * Class Size
 *
 * @package App\Core\Request\Validator\Rules
 */
class Size implements RuleInterface
{
    /**
     * @param array $data
     *
     * @return mixed|string
     */
    public function check(array $data)
    {
        foreach ($data['input'] as $input) {
            if ($input['size'] > $data['value']) {
                return "File '{$input['name']}' is too large!";
            }
        }
    }
}
