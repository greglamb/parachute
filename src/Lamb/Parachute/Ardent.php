<?php namespace Lamb\Parachute;

abstract Ardent extends \LaravelBook\Ardent\Ardent {
    
    public static function configureAsExternal(array $connection) {
        parent::configureAsExternal($connection);
    }
    
}
