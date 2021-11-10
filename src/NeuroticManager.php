<?php

namespace Syntac\Neurotic;

use GuzzleHttp\Client as GuzzleHTTPClient;

class NeuroticManager
{
	/**
	 * @var null|string
	 */
	protected ?string $token;
	
	/**
	 * @var null|string
	 */
	protected ?string $url;

	/**
	 * @var \GuzzleHttp\Client
	 */
	protected GuzzleHTTPClient $http;

	/**
	 * Create new new Neurotic manager instnace.
	 * 
	 * @param null|string $token
	 * @param null|string $url
	 * @return void
	 */
	public function __construct(string $token = null, string $url = null)
	{
		$this->token = $token ?? config('neurotic.token');
		$this->url = $url ?? config('neurotic.url');

		abort_if(empty($this->token), 400, __('neurotic::neurotic.token_not_configurated'));
		abort_if(empty($this->url), 400, __('neurotic::neurotic.url_not_configurated'));

		$this->http = new GuzzleHTTPClient([
			'base_url' => $this->url . '/api',
			'headers' => [
				'x-api-token' => $this->token,
			],
		]);
	}

	/**
	 * Get content types.
	 * 
	 * @return mixed
	 */
	public function contentTypes()
	{
		$payload = $this->http
			->get('/content_types')
			->getBody()
			->getContents();

		return collect($payload);
	}
}