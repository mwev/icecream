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

namespace Mweaver\IceCreamStore;

/**
 * Description of MilkShake
 *
 * @author MIchael
 */
use Mweaver\IceCreamStore\IceCreamProduct;
use Mweaver\IceCreamStore\Components\Milks;
use Mweaver\IceCreamStore\Discounts;

/**
 * Represents a single Milkshake
 */
class MilkShake extends IceCreamProduct {

    protected $milk;
    protected $discount;
    private $logger;

    /**
     * Complete data to build a milk shake
     * @param String $iceCreamId Must be in collection IceCreams
     * @param Integer $quantity how many scoops of icecream
     * @param String $milkId Must be in collection Milks
     * @param Integer $discountId Must be in collection Discounts
     */
    public function __construct($iceCreamId, $quantity, $milkId, $discountId = null) {
        $this->logger = \Monolog\Registry::getInstance(ICE_CREAM_LOG);
        $this->logger->addNotice($this->buildMsg($iceCreamId, $quantity, $milkId, $discountId));
        $this->addScoops($iceCreamId, $quantity);
        $this->milk = Milks::getInstance()->getItem($milkId);
        $this->discount = isset($discountId) ?
                1 - Discounts::getInstance()->getItem($discountId) : null;
    }

    /**
     * 
     * @return Float Total price of milk shake with any applied discount;
     */
    function getPrice() {
        $price = parent::getPrice() + $this->milk->getPrice() * $this->scoopCnt;
        return round(
                (isset($this->discount) ? $price * $this->discount : $price)
                , 2);
    }

    /**
     * Build a nice humman readable message for logging milk shake congig;
     * @param String $iceCreamId 
     * @param Integer $quantity
     * @param Integer $milkId
     * @param Integer $discountId
     * @return String
     */
    function buildMsg($iceCreamId, $quantity, $milkId, $discountId) {
        $msg =  "Building a MilkShake with $milkId milk";
        $msg .=  " and $quantity scoops $iceCreamId";
        if (isset($discountId))
            $msg .= (" with a discocunt of $discountId");

        $msg .= "\n";
        return $msg;
    }

}
