<?php namespace Lamb\Parachute;

class Database extends DatabaseCapsule {

    public function __construct(array $connection) {
        Ardent::configureAsExternal($connection);
    }

}
