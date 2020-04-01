<?php

namespace App\Core\Request\Validator\Rules;

/**
 * Interface RuleInterface
 *
 * @package App\Core\Request\Validator\Rules
 */
interface RuleInterface
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    public function check(array $data);
}
