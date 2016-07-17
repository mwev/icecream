<?php

/*
 * The MIT License
 *
 * Copyright 2015 MIchael.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Mweaver\IceCreamStore\Test;

/**
 * Description of Test2
 *
 * @author MIchael
 */
use Mweaver\IceCreamStore\Components\IceCream;
use Mweaver\IceCreamStore\Components\Cones;
use Mweaver\IceCreamStore\Components\IceCreams;
use Mweaver\IceCreamStore\Components\Milks;
use Mweaver\IceCreamStore\Components\Sodas;
use Mweaver\IceCreamStore\IceCreamCone;
use Mweaver\IceCreamStore\Discounts;
use Mweaver\IceCreamStore\MilkShake;
use Mweaver\IceCreamStore\Float;
use \Exception;

/**
 * Non framework old school testing. Most of the information displays when
 * log level is NOTICE or lower so don't set log level up for testing
 */
class Test2 {

    /**
     * Set up the individual tests.
     */
    function __construct() {
        $this->testIceCreamCone();
        $this->testMilkShake();
        $this->testFloat();
    }

    /**
     * Run all ice cream cone tests
     */
    function testIceCreamCone() {
        // All cone IDs
        $coneIds = Cones::getInstance()->keys();
        
        // All IceCreamIds
        $iceCreamIds = IceCreams::getInstance()->keys();
       

        // Happy Path
        $this->runIceCreamTest($coneIds[0], [$iceCreamIds[0] => 1, $iceCreamIds[1] => 1]);
        // Observe differnt price
        $this->runIceCreamTest($coneIds[1], [$iceCreamIds[4] => 1]);
        // To Many scoops
        $this->runIceCreamTest($coneIds[0], [$iceCreamIds[0] => 1, $iceCreamIds[1] => 2]);
        // To few scoops
        $this->runIceCreamTest($coneIds[0], []);
        // Ice cream requested not available
        $this->runIceCreamTest($coneIds[1], ['Mango' => 1]);
    }

    /**
     * Ice cream cone test runner
     * @param String $coneId
     * @param array $iceCreams
     */
    public function runIceCreamTest($coneId, $iceCreams) {
        try {
            $cone = new IceCreamCone($coneId, $iceCreams);
            echo "Price of cone is $" . $cone->getPrice() . "\n";
        } catch (Exception $e) {
            echo ">>Error: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Runs all milk shake tests
     */
    function testMilkShake() {
        // All milk ids
        $milkIds = Milks::getInstance()->keys();
        $iceCreamIds = IceCreams::getInstance()->keys();
        $discountIds = Discounts::getInstance()->keys();
        // Happy Path
        $this->runMilkShakeTest($iceCreamIds[0], 3, $milkIds[1]);
        // Happy Path with discount;
        $this->runMilkShakeTest($iceCreamIds[0], 3, $milkIds[1], $discountIds[1]);
    }

    /**
     * Runs all Float tests
     */
    function testFloat() {
        $sodaIds = Sodas::getInstance()->keys();
        $iceCreamIds = IceCreams::getInstance()->keys();
        $discountIds = Discounts::getInstance()->keys();
        // Happy Path
        $this->runFloatTest([$iceCreamIds[0] => 2, $iceCreamIds[1] => 1], $sodaIds[1]);
        //Happy Path with a discount;
        $this->runFloatTest([$iceCreamIds[0] => 2, $iceCreamIds[1] => 1], $sodaIds[1], $discountIds[0]);
        // Happy Path  again with alternate components;
        $this->runFloatTest([$iceCreamIds[3] => 2], $sodaIds[2]);
    }

   /**
    * Milk shake test runner
    * @param String $iceCreamId
    * @param Integer $quantity
    * @param String $milkId
    * @param String $discountId
    */
    function runMilkShakeTest($iceCreamId, $quantity, $milkId, $discountId = null) {
        try {
            $milkShake = new MilkShake($iceCreamId, $quantity, $milkId, $discountId);
            echo "Price of milkShake is $ " . $milkShake->getPrice() . "\n";
        } catch (Exception $e) {
            echo ">>Error: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Float test runner
     * @param array $iceCreams
     * @param String $sodaId
     * @param String $discountId
     */
    function runFloatTest($iceCreams, $sodaId, $discountId = null) {
        try {
            $float = new Float($sodaId, $iceCreams, $discountId);
            echo "Price of Float is $ " . $float->getPrice() . "\n";
        } catch (Exception $e) {
            echo ">>Error: " . $e->getMessage() . "\n";
        }
    }

}
