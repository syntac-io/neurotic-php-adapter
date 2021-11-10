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
			'base_uri' => $this->url . '/api/',
			'headers' => [
				'Accept' => 'application/json',
				'x-api-token' => $this->token,
			],
		]);
	}

	/**
	 * Get all content types.
	 * 
	 * @return mixed
	 */
	public function getContentTypes()
	{
		$payload = $this->http
			->get('content_types')
			->getBody()
			->getContents();

		return json_decode($payload);
	}

	/**
	 * Get content type by identifier.
	 * 
	 * @param string $identifier
	 * @return mixed|static
	 */
	public function getContentType(string $identifier)
	{
		$payload = $this->http
			->get('content_types/' . $identifier)
			->getBody()
			->getContents();

		return json_decode($payload);
	}

	/**
	 * Get all or specific content.
	 * 
	 * @param string $contentTypeID
	 * @param null|string $contentID
	 * @return mixed|static
	 */
	public function getContent(string $contentTypeID, string $contentID = null)
	{
		if ($contentID) {
			$payload = $this->http
				->get('content_types/' . $contentTypeID . '/content/' . $contentID)
				->getBody()
				->getContents();

			return json_decode($payload);
		}

		$payload = $this->http
			->get('content_types/' . $contentTypeID . '/content')
			->getBody()
			->getContents();

		return json_decode($payload);
	}
}