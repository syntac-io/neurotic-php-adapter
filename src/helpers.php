<?php

/**
 * Create a new Neurotic manager instance.
 * 
 * @param string $token
 * @param string $url
 * @return NeuroticManager
 */

use Syntac\Neurotic\NeuroticManager;

if (!function_exists('neurotic')) {
	function neurotic(string $token = null, string $url = null)
	{
		return new NeuroticManager($token, $url);
	}
}