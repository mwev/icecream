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

namespace Mweaver\Types;

use \Exception;
/**
 * Collection wraps an array. In theory it does 2 things. Encapsulates how we
 * store the collectiona and also keep user from copying out the array to do 
 * looksups whicc creates copies and probably should be avoided in heavily used
 * classes that use this class.
 * @todo consider if should just expose the array or find a nice public replacement
 *
 * @author MIchael
 */
Trait Collection {
    protected $collection = [];
    
    public function getItem($id)
    {
        if ($this->itemIsSet($id))
            return ($this->collection[$id]);
        else {
            throw new Exception("Attempt to access non collection item $id");
        }
    }
    
    public function itemIsSet($id)
    {
        return (isset($this->collection[$id]));
    }
    
    public function keys()
    {
        return array_keys($this->collection);     
    }
    
    public function addItem($id, $item)
    {
        $this->collection[$id] = $item;
    }
    
    public function addById($item)
    {
        $this->addItem($item->getId(), $item);
    }
}
