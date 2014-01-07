<?php namespace Lamb\Parachute;

use Illuminate\Database\DatabaseManager;
use Lamb\LaravelGenericDatabase\ConnectionFactory;

class DatabaseCapsule extends \Illuminate\Database\Capsule\Manager {

        protected function setupManager()
        {
            $factory = new ConnectionFactory($this->container);
            $this->manager = new DatabaseManager($this->container, $factory);
        }

}

