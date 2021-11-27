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
	}

	/**
	 * Boot method.
	 * 
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__ . '/../config/neurotic.php' => config_path('neurotic.php'),
		]);

		$this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'neurotic');

		if ($this->app->runningInConsole()) {
			$this->commands([
				SyncCommand::class,
			]);
		}
	}
}
