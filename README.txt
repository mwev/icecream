This code was created and tested on a PC  running PHP 5.6.3. There should be no issues running it on Linux other then changing the bat file to a shell script for phpunit but it has not been tested. I simply removed the vendor dir and zipped the files under my development directory and thats what is here. 

To run the code move to the top level directory of the included files and run the script <<run.php>>. This sets up the autoloader and the logging environment. All logging is going to stdout as configured and only the messages are being displayed with no other information. 

To run the unit tests move to the test directory app/IceCreamStore/Test and follow the example in run.bat. The basic idea is to get to the phpunit runner located in the vendor\bin dir. The –bootstrap boostrap.php argument again sets up the loging env. Phpunit apparently uses the autoloader located in vendor dir.

I only loaded phpunit and monolog via composer the rest of the environment should be standard PHP.
