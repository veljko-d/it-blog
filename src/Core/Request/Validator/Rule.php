<?php

namespace App\Core\Request\Validator;

use App\Core\Container\Container;
use App\Core\Request\Validator\Rules\Between;
use App\Core\Request\Validator\Rules\Different;
use App\Core\Request\Validator\Rules\Extension;
use App\Core\Request\Validator\Rules\Max;
use App\Core\Request\Validator\Rules\Min;
use App\Core\Request\Validator\Rules\Required;
use App\Core\Request\Validator\Rules\Same;
use App\Core\Request\Validator\Rules\Size;
use App\Core\Request\Validator\Rules\Type;

/**
 * Class Rule
 *
 * @package App\Core\Request\Validator
 */
class Rule
{
    /**
     * @const
     */
    public const REQUIRED = 'required';

    /**
     * @const
     */
    private const TYPE = 'type';

    /**
     * @const
     */
    private const SAME = 'same';

    /**
     * @const
     */
    private const DIFFERENT = 'different';

    /**
     * @const
     */
    private const MIN = 'min';

    /**
     * @const
     */
    private const MAX = 'max';

    /**
     * @const
     */
    private const SIZE = 'size';

    /**
     * @const
     */
    private const BETWEEN = 'between';

    /**
     * @const
     */
    private const EXT = 'ext';

    /**
     * @const
     */
    private const RULES = [
        self::TYPE      => Type::class,
        self::SAME      => Same::class,
        self::DIFFERENT => Different::class,
        self::MIN       => Min::class,
        self::MAX       => Max::class,
        self::SIZE      => Size::class,
        self::BETWEEN   => Between::class,
        self::EXT       => Extension::class,
    ];

    /**
     * @var array
     */
    private $inputs = [];

    /**
     * @param string $field
     * @param array  $rules
     * @param        $input
     *
     * @return string|null
     * @throws \ReflectionException
     */
    public function check(string $field, array $rules, $input)
    {
        $rulesMatched = array_intersect_key($rules, self::RULES);
        $this->inputs[$field] = $input;
        $field = ucwords(str_replace('_', ' ', $field));

        $required = (Container::getInstance())->get(Required::class);

        if (($message = $required->check($field, $rules, $input)) === false) {
            return null;
        } elseif (is_string($message)) {
            return $message;
        }

        foreach ($rulesMatched as $rule => $value) {
            if ($message = $this->instantiate($field, $input, $rule, $value)) {
                return $message;
            }
        }
    }

    /**
     * @param string $field
     * @param        $input
     * @param string $rule
     * @param        $value
     *
     * @return mixed
     * @throws \ReflectionException
     */
    private function instantiate(string $field, $input, string $rule, $value)
    {
        $ruleInstance = (Container::getInstance())->get(self::RULES[$rule]);

        $arguments = [
            'field'  => $field,
            'input'  => $input,
            'value'  => $value,
            'inputs' => $this->inputs,
        ];

        return $ruleInstance->check($arguments);
    }
}
