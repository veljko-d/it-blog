<?php

namespace App\Core\Request\Validator\Rules;

use App\Core\Container\Container;
use App\Core\Request\Validator\Rules\Types\Alphabetic;
use App\Core\Request\Validator\Rules\Types\Filter;
use App\Core\Request\Validator\Rules\Types\File;
use App\Core\Request\Validator\Rules\Types\Image;
use App\Exceptions\InvalidTypeException;

/**
 * Class Type
 *
 * @package App\Core\Request\Validator\Rules
 */
class Type implements RuleInterface
{
    /**
     * @const
     */
    public const EMAIL = 'email';

    /**
     * @const
     */
    public const FLOAT = 'float';

    /**
     * @const
     */
    public const INTEGER = 'integer';

    /**
     * @const
     */
    public const URL = 'url';

    /**
     * @const
     */
    private const ALPHABETIC = 'alpha';

    /**
     * @const
     */
    private const FILE = 'file';

    /**
     * @const
     */
    private const IMAGE = 'image';

    /**
     * @const
     */
    private const TYPES = [
        self::EMAIL      => Filter::class,
        self::FLOAT      => Filter::class,
        self::INTEGER    => Filter::class,
        self::URL        => Filter::class,
        self::ALPHABETIC => Alphabetic::class,
        self::FILE       => File::class,
        self::IMAGE      => Image::class,
    ];

    /**
     * @param array $data
     *
     * @return mixed
     * @throws InvalidTypeException
     * @throws \ReflectionException
     */
    public function check(array $data)
    {
        $type = $data['value'];

        if (!isset(self::TYPES[$type])) {
            throw new InvalidTypeException("Invalid data type: '{$type}'");
        }

        return $this->instantiate($data['field'], $data['input'], $type);
    }

    /**
     * @param string $field
     * @param        $input
     * @param string $type
     *
     * @return mixed
     * @throws \ReflectionException
     */
    private function instantiate(string $field, $input, string $type)
    {
        $typeInstance = (Container::getInstance())->get(self::TYPES[$type]);

        $arguments = [
            'field' => $field,
            'input' => $input,
            'type'  => $type,
        ];

        return $typeInstance->check($arguments);
    }
}
