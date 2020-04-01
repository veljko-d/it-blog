<?php

namespace App\Core\Request;

/**
 * Class QueryFilter
 *
 * @package App\Core\Request
 */
class QueryFilter
{
    /**
     * @const
     */
    private const PAGE = 'page';

    /**
     * @const
     */
    private const SEARCH = 'search';

    /**
     * @var FilteredMap
     */
    private $params;

    /**
     * Validator constructor.
     *
     * @param FilteredMap $params
     */
    public function __construct(FilteredMap $params)
    {
        $this->params = $params;
    }

    /**
     * @param string $param
     *
     * @return mixed|null
     */
    public function get(string $param)
    {
        return ($this->params->has($param)) ? $this->params->get($param) : null;
    }

    /**
     * @return int
     */
    public function page(): int
    {
        $has = $this->params->has(self::PAGE);
        $getInteger = $this->params->getInteger(self::PAGE);

        if ($has && $getInteger !== 0) {
            return $getInteger;
        }

        return 1;
    }

    /**
     * @return string
     */
    public function search(): string
    {
        if ($this->params->has(self::SEARCH)) {
            return $this->params->getString(self::SEARCH);
        }

        return "";
    }
}
