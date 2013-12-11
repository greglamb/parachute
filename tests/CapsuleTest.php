<?php

use Lamb\Parachute\Capsule as Parachute;

class ParachuteTest extends PHPUnit_Framework_TestCase {

    public function testVersion() {
        $db = new Parachute(array(
                'driver'   => 'generic',
                'dsn'      => 'odbc:DRIVER={IBM DB2 ODBC DRIVER};HOSTNAME=localhost;PORT=50000;DATABASE=SAMPLE;PROTOCOL=TCPIP;UID=db2inst1;PWD=ibmdb2;'
            ));

        var_dump(
            Parachute::select('SELECT version()')
        );
    }

}
