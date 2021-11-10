<?php

namespace Syntac\Neurotic;

use Illuminate\Support\ServiceProvider;

class NeuroticServiceProvider extends ServiceProvider
{
	/**
	 * Register method.
	 * 
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('neurotic-manager', fn () => new NeuroticManager);
		$this->mergeConfigFrom(__DIR__ . '/../config/neurotic.php', 'neurotic');
	}

	/**
	 * Boot method.
	 * 
	 * @return void
	 */
	public function boot()
	{
		$this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'neurotic');
	}
}
