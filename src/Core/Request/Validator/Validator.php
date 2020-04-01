<?php

namespace App\Core\Request\Validator;

use App\Core\Container\Container;
use App\Core\Request\FilteredMap;
use App\Exceptions\NotFoundException;

/**
 * Class Validator
 *
 * @package App\Core\Request\Validator
 */
class Validator
{
    /**
     * @var FilteredMap
     */
    private $data;

    /**
     * @var Rule
     */
    private $rule;

    /**
     * Validator constructor.
     *
     * @param FilteredMap $data
     *
     * @throws \ReflectionException
     */
    public function __construct(FilteredMap $data)
    {
        $this->data = $data;
        $this->rule = (Container::getInstance()->get(Rule::class));
    }

    /**
     * @param array $validationFields
     *
     * @return array
     * @throws NotFoundException
     * @throws \ReflectionException
     */
    public function validate(array $validationFields): array
    {
        $inputs = [];

        foreach ($validationFields as $field => $rules) {
            if (!$this->data->has($field)) {
                throw new NotFoundException("Field '$field' does not exists!");
            }

            $inputs[$field] = $input = $this->data->get($field);

            if ($message = $this->rule->check($field, $rules, $input)) {
                $errors[] = $message;
            }
        }

        return empty($errors) ? ['inputs' => $inputs] : ['errors' => $errors];
    }
}
