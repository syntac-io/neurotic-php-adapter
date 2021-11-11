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
	 * @return array
	 */
	public function getContentTypes()
	{
		try {
			$payload = $this->http
				->get('content_types')
				->getBody()
				->getContents();
		} catch(\Throwable $e) {
			return [];
		}

		return json_decode($payload, true);
	}

	/**
	 * Get content type by identifier.
	 * 
	 * @param string $identifier
	 * @return array
	 */
	public function getContentType(string $identifier)
	{
		try {
			$payload = $this->http
				->get('content_types/' . $identifier)
				->getBody()
				->getContents();
		} catch(\Throwable $e) {
			return [];
		}

		return json_decode($payload, true);
	}

	/**
	 * Get all or specific content.
	 * 
	 * @param string $contentTypeID
	 * @param null|string|array $constraint
	 * @return array
	 */
	public function getContent(string $contentTypeID, $constraint = null)
	{
		// Get all content associated with content type.
		if (!$constraint) {
			try {
				$payload = $this->http
					->get('content_types/' . $contentTypeID)
					->getBody()
					->getContents();
			} catch(\Throwable $e) {
				return [];
			}

			return json_decode($payload, true);
		}

		// Get all content associated with content type with constrains applied.
		if (is_array($constraint)) {
			try {
				$payload = $this->http
					->get('content_types/' . $contentTypeID . '/content?where=' . json_encode($constraint))
					->getBody()
					->getContents();
			} catch(\Throwable $e) {
				return [];
			}

			return json_decode($payload, true);
		}

		// Get content associated with identifier and content type.
		try {
			$payload = $this->http
				->get('content_types/' . $contentTypeID . '/content/' . $constraint)
				->getBody()
				->getContents();
		} catch(\Throwable $e) {
			return [];
		}

		return json_decode($payload, true);
	}
}