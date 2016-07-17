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

use Mweaver\IceCreamStore\Components\IceCreams;

/**
 * IceCreamProduct is base class for product made with ice cream.
 *
 * @author MIchael
 */
class IceCreamProduct {

    const iceCream = "iceCream";
    const quantity = "quantity";
    
    protected $scoops = [];
    protected $scoopCnt = 0;
   

    /**
     * Given the IceCreamId get the associated IceCream object. 
     * Store both object and quantity
     * @param String $iceCreamId
     * @param Integer $quantity
     */
    protected function addScoops($iceCreamId, $quantity) {
        $iceCreams = IceCreams::getInstance();
        $iceCream = $iceCreams->getItem($iceCreamId);
        $this->scoops[] = [self::iceCream => $iceCream, self::quantity => $quantity];
        $this->scoopCnt += $quantity;
    }
    /**
     * Returns the total price of all iceCream used in product
     * @return Float
     */
    function getPrice() {
        $price = 0;
        $quantity = 0;
        foreach($this->scoops as $scoop)
        {
            $price += $scoop[self::iceCream]->getPrice() * $scoop[self::quantity];
        }
        return $price;
    }

}
