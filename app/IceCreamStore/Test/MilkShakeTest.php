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
use Mweaver\IceCreamStore\MilkShake;
use Mweaver\IceCreamStore\Components\IceCream;
use Mweaver\IceCreamStore\Components\IceCreams;
use Mweaver\IceCreamStore\Components\Milks;
use Monolog\Registry;
use Mweaver\IceCreamStore\Discounts;

class MilkShakeTest extends PHPUnit_Framework_TestCase {

    protected $iceCreamIds;
    protected $milkIds;
    protected $discountIds;

    protected function setUp() {
        $this->iceCreamIds = IceCreams::getInstance()->keys();
        $this->milkIds = Milks::getInstance()->keys();
        $this->discountIds = Discounts::getInstance()->keys(); 
    }
    
    function testPrice()
    {
         $shake = new MilkShake($this->iceCreamIds[0], 3, $this->milkIds[1]);
         $this->assertEquals(5.25, $shake->getPrice());
    }
    
     function testDiscountPrice()
    {
         $shake = new MilkShake($this->iceCreamIds[0], 3, $this->milkIds[1], $this->discountIds[1]);
         $price = $shake->getPrice();
         $this->assertEquals(3.94, $price);
    }
    
    /**
     * @expectedException        Exception
     * @expectedExceptionMessage access non collection
     */
    function testNotInCollection() {
          new MilkShake('Mango', 4, $this->milkIds[1]);
    }
}