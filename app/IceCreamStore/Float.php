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

use Mweaver\IceCreamStore\IceCreamProduct;
use Mweaver\IceCreamStore\Components\Sodas;
use Mweaver\IceCreamStore\Discounts;

/**
 * Represents an IceCream Float;
 *
 * @author MIchael
 */
class Float extends IceCreamProduct {

    protected $soda;
    protected $discount;
    private $logger;
    
    /**
     * All Data required to build a float
     * @param String $sodaId
     * @param array $scoops
     * @param String $discountId
     */
    public function __construct($sodaId, array $scoops, $discountId = null) {
        $this->logger = \Monolog\Registry::getInstance(ICE_CREAM_LOG);
        $this->logger->addNotice($this->buildMsg($sodaId, $scoops, $discountId));
        foreach ($scoops as $iceCreamId => $quantity)
            $this->addScoops($iceCreamId, $quantity);
        $this->soda = Sodas::getInstance()->getItem($sodaId);
        $this->discount = isset($discountId) ? 
                1 - Discounts::getInstance()->getItem($discountId) : null;  
    }
    
    /**
     * Reeturns total Cost to build a Float (rounded up to penny)
     * @return Float
     */
   function getPrice()
    {
        $price = parent::getPrice() + $this->soda->getPrice() * $this->scoopCnt;
        return round(isset($this->discount) ?  $price * $this->discount : $price, 2);
    }
    /**
     * Make a Nice Human readabe message describing Float configuration ,
     * @param String $sodaId
     * @param array $scoops
     * @param String $discountId
     * @return String
     */
    function buildMsg($sodaId, $scoops, $discountId)
    {
       $msg =  "Building a Float with $sodaId soda";
       foreach ($scoops as $id => $quantity) {
            $msg .= " and $quantity scoops $id";
        }
        if (isset($discountId)) {
            $msg .= (" with a discount of $discountId");
        }
        $msg .= "\n";
        return $msg;
    }
}
