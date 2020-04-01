<?php

namespace App\Core\Request\Validator\Rules\Types;

use App\Core\Request\Validator\Rules\Type;

/**
 * Class Filter
 *
 * @package App\Core\Request\Validator\Rules\Types
 */
class Filter implements TypeInterface
{
    /**
     * @const
     */
    private const FILTERS = [
        Type::EMAIL   => FILTER_VALIDATE_EMAIL,
        Type::FLOAT   => FILTER_VALIDATE_FLOAT,
        Type::INTEGER => FILTER_VALIDATE_INT,
        Type::URL     => FILTER_VALIDATE_URL,
    ];

    /**
     * @param array $data
     *
     * @return mixed|string
     */
    public function check(array $data)
    {
        if (!filter_var($data['input'], self::FILTERS[$data['type']])) {
            return "'{$data['input']}' is not a valid {$data['type']}";
        }
    }
}
