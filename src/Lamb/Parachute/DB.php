<?php namespace Lamb\Parachute;

use PDO;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\DatabaseManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Lamb\LaravelGenericDatabase\ConnectionFactory;

class DB extends Manager {

  public function __construct(Container $container = null) { }

  public static function configureConnections(array $connections, $default = 'default') {
    $db = new self;

    $db->setupContainer(new Container);
    $db->container['config']['database.fetch'] = PDO::FETCH_ASSOC;
    $db->container['config']['database.default'] = $default;
    $db->setupManager();

    $db->addConnections($connections);

    $db->setEventDispatcher(new Dispatcher(new Container));
    $db->setAsGlobal();
    $db->bootEloquent();

    Model::setValidator($db);
  }

  public function addConnections(array $new_connections)
  {
    $connections = $this->container['config']['database.connections'];
    if (!is_array($connections)) { $connections = array(); }
    $connections = array_merge($connections, $new_connections);
    $this->container['config']['database.connections'] = $connections;
  }

  protected function setupManager()
  {
    $factory = new ConnectionFactory($this->container);
    $this->manager = new DatabaseManager($this->container, $factory);
  }

}
