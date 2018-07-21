<?php

namespace Tekord\Logman\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @author Cyrill Tekord
 */
class Logman extends Facade {
	/**
	 * @inheritdoc
	 */
	protected static function getFacadeAccessor() {
		return 'logman';
	}
}
