<?php
namespace CodeMyViews\Upwork;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for the Upwork php library service
 */
class UpworkFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'upwork';
    }
}