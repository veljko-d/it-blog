<?php

namespace App\Core;

use App\Exceptions\NotFoundException;

/**
 * Class Config
 *
 * @package App\Core
 */
class Config
{
    /**
     * @var mixed
     */
	private $data;

    /**
     * Config constructor.
     */
	public function __construct()
    {
		$this->data = require __DIR__ . '/../../config/app.php';
	}

    /**
     * @param $key
     *
     * @return mixed
     */
	public function get($key)
    {
		try {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            }

            throw new NotFoundException("Key $key not found");
        } catch (NotFoundException $e) {
            echo $e->getMessage();
        }
	}
}
