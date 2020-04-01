<?php

namespace App\Core\Request\Validator\Rules;

/**
 * Class Extension
 *
 * @package App\Core\Request\Validator\Rules
 */
class Extension implements RuleInterface
{
    /**
     * @param array $data
     *
     * @return mixed|string
     */
    public function check(array $data)
    {
        $extensions = array_flip(explode(',', $data['value']));

        foreach ($data['input'] as $input) {
            $ext = strtolower(pathinfo($input['name'], PATHINFO_EXTENSION));

            if (!array_key_exists($ext, $extensions)) {
                return "File type '$ext' not supported!";
            }
        }

    }
}
