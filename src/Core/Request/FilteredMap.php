<?php

namespace App\Core\Request;

/**
 * Class FilteredMap
 *
 * @package App\Core
 */
class FilteredMap
{
    /**
     * @var array
     */
	private $map;

    /**
     * FilteredMap constructor.
     *
     * @param array $baseMap
     */
	public function __construct(array $baseMap)
    {
		$this->map = $baseMap;
	}

    /**
     * @param string $name
     *
     * @return bool
     */
	public function has(string $name): bool
    {
		return isset($this->map[$name]);
	}

    /**
     * @param string $name
     *
     * @return mixed|null
     */
	public function get(string $name)
    {
		return $this->map[$name] ?? null;
	}

    /**
     * @param string $name
     *
     * @return int
     */
	public function getInteger(string $name): int
    {
		return (int) $this->get($name);
	}

    /**
     * @param string $name
     *
     * @return float
     */
	public function getFloat(string $name): float
    {
		return (float) $this->get($name);
	}

    /**
     * @param string $name
     * @param bool   $filter
     *
     * @return string
     */
	public function getString(string $name, bool $filter = true): string
    {
		$value = (string) $this->get($name);

		return $filter ? addslashes($value) : $value;
	}
}
