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

use Mweaver\IceCreamStore\Components\Cones;
use \Exception;
use Monolog\Registry;

/**
 * IceCreamCone: Represents a single Ice Cream Cone
 *
 * @author Michael
 */
class IceCreamCone extends IceCreamProduct {

    // Min and Max number of scoops allowed for a cone.
    const MaxScoop = 2;
    const MinScoop = 1;

    protected $logger;
    protected $cone;
    static protected $rangeMessage = "";

    /**
     * Construct an Ice Cream cone.
     * @param String $coneFlavor;
     * @param array $scoops
     * @throws Exception
     */
    function __construct($coneId, array $scoops) {
        $this->logger = Registry::getInstance(ICE_CREAM_LOG);
        $this->logger->addDebug("Constructing with coneId: $coneId, scoops: " 
                . print_r($scoops, TRUE));
        $this->logger->addNotice($this->buildMsg($coneId, $scoops));
        $this->cone = Cones::getInstance()->getItem($coneId);
        foreach ($scoops as $iceCreamId => $quantity)
            $this->addScoops($iceCreamId, $quantity);
        if ($this->scoopCnt < self::MinScoop)
            $this->throwRangeException();
    }

    /**
     * Add scoops of a single flavor to the cone
     * @param String $id. Id to single record representing all instances
     * of this icecream type
     * @param int $quantity
     * @throws Exception
     */
    function addScoops($id, $quantity) {
        parent::addScoops($id, $quantity);
        // Check for scoop range exceeded
        if ($this->scoopCnt > self::MaxScoop)
            $this->throwRangeException();
    }

    /**
     * Get the price of the ice Cream cone as configured
     * @return float.
     */
    function getPrice() {
        return parent::getPrice() + $this->cone->getPrice();
    }


    /**
     * Untility to not repeat msg
     * TODO: Create appropriate subclass exception
     * @throws Exception
     */
    protected function throwRangeException()
    {
        throw new Exception("Scoops count $this->scoopCnt not in allowed range of " .
            self::MinScoop . " - " . self::MaxScoop);
    }
    
    /**
     
     */
    /**
     * Utility to build nice human readable msg for logging
     * @todo Consider performance impact. No easy way to determine effective 
     * log level so how do we avoid building big strings that won't be 
     * logged and impact production.
     * @param type $coneId
     * @param array $scoops
     * @return string
     */
    function buildMsg($coneId, array $scoops)
    {
        $msg = "Building ice Cream cone with $coneId cone ";
        foreach ($scoops as $id => $quantity) {
            $msg .= " and $quantity scoops $id";
        }
        $msg .= "\n";
        return $msg;
    }
    
}
