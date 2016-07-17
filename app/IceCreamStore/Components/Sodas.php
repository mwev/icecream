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

namespace Mweaver\IceCreamStore\Components;
use Mweaver\IceCreamStore\Components\Component;
use Mweaver\Types\Collection;
use Mweaver\Types\Singleton;

/**
 * Sodas is a Singleton of all available sodas;
 *
 * @author MIchael
 */

class Sodas {
    use Singleton;
    use Collection;
    private $logger;
    protected function init()
    {
        $this->logger = \Monolog\Registry::getInstance(ICE_CREAM_LOG);
        $this->addById(new Component ('Coke', .15));      
        $this->addById(new Component ('Rootbeer', .10));
        $this->addById(new Component ('Grape', .10));  
        /**
         * todo consider moving all the logging down to Collection We are 
         * repeating this. DNRY
         */
        $this->logger->addInfo("Creating Sodas singeton " . print_r($this->keys(), TRUE));
    }
}