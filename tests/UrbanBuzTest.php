<?php

use UrbanBuz\API\UrbanBuz;

class UrbanBuzTest extends PHPUnit_Framework_TestCase
{

    public function testHeartbeat()
    {
        $urbanbuz = new UrbanBuz('EwEi1QBfX1I64nrJhPVW', 'gMOwRr7MOo5uhQPgXIII');
        $this->assertTrue($urbanbuz->heartbeat());
    }
}
