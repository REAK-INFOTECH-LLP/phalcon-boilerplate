<?php

use Phalcon\Di;
use Phalcon\Test\UnitTestCase as PhalconTestCase;

abstract class UnitTestCase extends PhalconTestCase
{
    /**
     * @var bool
     */
    private $_loaded = false;



    public function setUp()
    {
        global $di;

        parent::setUp();

        // Load any additional services that might be required during testing
        \Phalcon\Di::setDefault($di);
        //$di = Di::getDefault();

        // Get any DI components here. If you have a config, be sure to pass it to the parent

        $di->setShared('config', function () {
            $config_ini = parse_ini_file(__DIR__ . "/../app/config/system.ini");
            if($config_ini["environment"] == "production"){
                return include __DIR__ . "/../app/config/config-production.php";
            }
            else {
                return include __DIR__ . "/../app/config/config.php";
            }
        });

        $this->setDi($di);
        
        $this->_loaded = true;
        $url = $this->di->get("config")->metadata->appUrl;
        $this->guzzle = new GuzzleHttp\Client([
            'base_uri' => $url
        ]);
    }

    public function tearDown(){
        \Mockery::close();
    }

    /**
     * Check if the test case is setup properly
     *
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            throw new \PHPUnit_Framework_IncompleteTestError(
                "Please run parent::setUp()."
            );
        }
    }
}
