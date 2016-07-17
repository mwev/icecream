<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mweaver;
use Monolog\Registry;
/**
 * Description of Test
 *
 * @author MIchael
 */

class Test {
    private $logger;
    function __construct() {
        $this->logger = Registry::getInstance(ICE_CREAM_LOG);
        $this->logger->addInfo("it Worked");
    }
}
