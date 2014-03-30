<?php

use \Lamb\Parachute\Model;
use \Lamb\Parachute\DB;

class Employee extends Model {

			protected $table = 'EMPLOYEE';
			protected $primaryKey = 'EMP_NO';
			protected $connection = 'firebird';

}

class FirebirdDBTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		$connections = [
			'firebird' => [
				'driver' => 'generic',
    		'dsn' => 'firebird:dbname=localhost:/var/lib/firebird/2.5/data/employee.fdb',
				'username' => 'SYSDBA',
				'password' => 'masterkey'
			]
		];

		DB::configureConnections($connections);
	}

	public function testQuery()
	{
			// Lack of grammar for Firebird doesn't make this intuitive

			$employee = Employee::where('EMP_NO', 37)->get();
			$lastname = $employee[0]->LAST_NAME;

      $this->assertEquals($lastname, 'Stansbury');
	}

}
