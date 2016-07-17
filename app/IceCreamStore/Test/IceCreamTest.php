<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IceCreamTest
 *
 * @author MIchael
 */
use Mweaver\IceCreamStore\IceCreamCone;
use Mweaver\IceCreamStore\Components\IceCream;
use Mweaver\IceCreamStore\Components\Cones;
use Mweaver\IceCreamStore\Components\IceCreams;
use Monolog\Registry;

class IceCreamTest extends PHPUnit_Framework_TestCase {

    protected $coneIds;
    protected $iceCreamIds;

    protected function setUp() {
        $this->iceCreamIds = IceCreams::getInstance()->keys();
        $this->coneIds = Cones::getInstance()->keys();
    }

    function testMaxRange() {

        $cone = new IceCreamCone($this->coneIds[0], [$this->iceCreamIds[0] => 1, $this->iceCreamIds[1] => 1]);
        $this->assertEquals(4.5, $cone->getPrice());
    }

    function testMinRange() {

        $cone = new IceCreamCone($this->coneIds[1], [$this->iceCreamIds[1] => 1]);
        $this->assertEquals(2.5, $cone->getPrice());
    }

    /*
      $this->runIceCreamTest($coneIds[0], [$iceCreamIds[0] => 1, $iceCreamIds[1] => 2]);
      // To few scoops
      $this->runIceCreamTest($coneIds[0], []);
      // Ice cream requested not available
      $this->runIceCreamTest($coneIds[1], ['Mango' => 1]);
      }
     * 
     */

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage not in allowed range
     */
    function testRangeOver() {
        $cone = new IceCreamCone($this->coneIds[0], [$this->iceCreamIds[0] => 1, $this->iceCreamIds[2] => 2]);
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage not in allowed range
     */
    function testRangeUnder() {
        $cone = new IceCreamCone($this->coneIds[0], []);
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage access non collection
     */
    function testNotInCollection() {
        $cone = new IceCreamCone($this->coneIds[0], ['Mango' => 1]);         
    }

}
