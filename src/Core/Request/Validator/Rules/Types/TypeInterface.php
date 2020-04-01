<?php

namespace App\Core\Request\Validator\Rules\Types;

/**
 * Interface TypeInterface
 *
 * @package App\Core\Request\Validator\Rules\Types
 */
interface TypeInterface
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    public function check(array $data);
}
