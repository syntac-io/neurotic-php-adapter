<?php

namespace Syntac\Neurotic;

use Illuminate\Support\Facades\Facade;

class NeuroticManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
		return 'neurotic-manager';
	}
}