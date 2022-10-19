<?php

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Collective\Html\HtmlServiceProvider as CollectiveHtml;

class TestServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application events.
	 * @return void
	 * @throws BindingResolutionException
	 */
	public function boot()
	{
		$this->loadViewsFrom(__DIR__ . '/resources/views', 'scripts');

		if ($this->app->runningInConsole()) {
			$this->publishAssets();
		}
	}

	/**
	 * Publish datatables assets.
	 * @throws BindingResolutionException
	 */
	protected function publishAssets()
	{
		$this->publishes([
			__DIR__ . '/resources/views'             => Container::getInstance()->make('',[])()->basePath('/resources/views/vendor/scripts'),
			__DIR__ . '/resources/config/config.php' => config_path('src/resources/config/config.php'),
		], 'scripts-html');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(__DIR__ . '/resources/config/config.php', 'config');

		$this->app->register(CollectiveHtml::class);
	}
}