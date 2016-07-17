<?php
require __DIR__ . '/vendor/autoload.php';
use Mweaver\IceCreamStore\Test\Test2;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Mweaver\Test;
/*
 * TODO: Other than passing around the log as an interface to each function
 * whichh is good ecapsulatio but messy IMHO, I don't know another great way
 * to pass logs. In Log4J (far better log implementation IMHO) you would create
 * a logger for each class. Not what seems to be done in PHP probably do
 * to the overhead.
 */
use Monolog\Registry; 

define("ICE_CREAM_LOG", "iceCream");
$log = new Logger(ICE_CREAM_LOG);
$output = "%message%\n";
$formatter = new LineFormatter($output);
$streamHandler = new StreamHandler('php://stdout', Logger::INFO);
$streamHandler->setFormatter($formatter);
$log->pushHandler($streamHandler);
Registry::addLogger($log);
//$log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING));
//$test = new Test();

$test = new Test2();


