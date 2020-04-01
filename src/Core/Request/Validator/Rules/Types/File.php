<?php

namespace App\Core\Request\Validator\Rules\Types;

/**
 * Class File
 *
 * @package App\Core\Request\Validator\Rules\Types
 */
class File implements TypeInterface
{
    /**
     * @param array $data
     *
     * @return mixed|string
     */
    public function check(array $data)
    {
        foreach ($data['input'] as $item) {
            if (!is_file($item['tmp_name'])) {
                return "'{$item['name']}' is not a valid file!";
            }
        }
    }
}
