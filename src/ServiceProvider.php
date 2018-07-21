<?php

namespace Tekord\Logman;

/**
 * @author Cyrill Tekord
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider {
	/**
	 * @inheritdoc
	 */
	public function register() {
		$this->app->alias(Logman::class, 'logman');
	}
}
