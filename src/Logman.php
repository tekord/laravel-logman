<?php

namespace Tekord\Logman;

/**
 * @author Cyrill Tekord
 */
class Logman {
	/**
	 * @var array stores accumulated context records.
	 */
	protected $context = [];

	/**
	 * Returns accumulated context records.
	 *
	 * @return array
	 */
	public function getContext() {
		return $this->context;
	}

	/**
	 * Returns accumulated context records merged with the given array. Used for convenience when you want to get
	 * records and add some custom ones within single row of code.
	 *
	 * @param array $extraRecords
	 *
	 * @return array
	 */
	public function getContextWith($extraRecords) {
		return array_merge($this->context, $extraRecords);
	}

	/**
	 * Puts record into context container. The value will be placed as is without regard to whether the value is null.
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param bool $overwriteIfAlreadyExists
	 */
	public function put($key, $value, $overwriteIfAlreadyExists = true) {
		if ($overwriteIfAlreadyExists) {
			$this->context[$key] = $value;
		}
		else {
			if (!array_key_exists($key, $this->context))
				$this->context[$key] = $value;
		}
	}

	/**
	 * Puts record into context container only if the value is NOT null.
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param bool $overwriteIfAlreadyExists
	 */
	public function putIfPresented($key, $value, $overwriteIfAlreadyExists = true) {
		if ($value === null)
			return;

		$this->put($key, $value, $overwriteIfAlreadyExists);
	}
}
