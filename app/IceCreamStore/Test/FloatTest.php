<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author MIchael
 */
use Mweaver\IceCreamStore\Float;
use Mweaver\IceCreamStore\Components\IceCream;
use Mweaver\IceCreamStore\Components\IceCreams;
use Mweaver\IceCreamStore\Components\Sodas;
use Monolog\Registry;
use Mweaver\IceCreamStore\Discounts;

class FloatTest extends PHPUnit_Framework_TestCase {

    protected $iceCreamIds;
    protected $sodaIds;
    protected $discountIds;

    protected function setUp() {
        $this->iceCreamIds = IceCreams::getInstance()->keys();
        $this->sodaIds = Sodas::getInstance()->keys();
        $this->discountIds = Discounts::getInstance()->keys();
    }

    function testPrice() {
        $float = new Float($this->sodaIds[1], [$this->iceCreamIds[0] => 1, $this->iceCreamIds[2] => 2]);
        $this->assertEquals(5.8, $float->getPrice());
    }

    function testDiscountPrice() {
        $float = new Float($this->sodaIds[1], [$this->iceCreamIds[0] => 1, $this->iceCreamIds[2] => 2], $this->discountIds[2]);
        //Dogs get a massive 90% discount !! Yeah
        $this->assertEquals(.58, $float->getPrice());
    }

    /**
     * @expectedException        Exception
     * @expectedExceptionMessage access non collection
     */
    function testNotInCollection() {
        new Float($this->sodaIds[1], ['Peach' => 1, $this->iceCreamIds[2] => 2], $this->discountIds[2]);
    }

}
