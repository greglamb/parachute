<?php

namespace Lamb\Parachute;

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class Capsule extends \Illuminate\Database\Capsule\Manager {
    
    public function __construct($configuration)
    {
        $this->setupContainer(null);
        $this->setupDefaultConfiguration();
        $this->setupManager();
        
        $this->addConnection($configuration);
        
        $this->setEventDispatcher(new Dispatcher(new Container));
        $this->setAsGlobal();
        
        $this->bootEloquent();
    }
    
}