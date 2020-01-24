<?php

namespace TestController;
/**
 * Class UnitTest
 */
class TestControllerUnitTest extends \UnitTestCase {
    /*
        Simple Unit Test to Test Controller Logic
        Functions should be isolated from DB / Request, to have this working properly.
    public function testsunittestfunctionTestCase() {
        $result = new \TestController;
        $result = $result->unitTest();
        $this->assertEquals(
            $result,
            "ThisWorks",
            "This is OK"
        );
    }

    /*
        Explaining integration tests, which basically simulates the module and
        compares the output with the desired output
    public function testsintegrationtestTestCase() {
        $response = $this->guzzle->post('test/integrationtest', [
            'form_params'  =>  [
                'data'  => '50',
            ]
        ]);

        $this->assertEquals(
            $response->getBody()->getContents(),
            "60",
            "Ideal value received"
        );
    }
    */

    public function testsdbcheckTestCase(){
        /*
         * Tests to write
         * 1. ::count throws exception, function should not exit
         * 2. ::count throws exception, function should log
         * 3. ::count throws exception, function should return random / 0 view value
         * 4. ::count returns value, function should set view var
        */
       /* 
        $this->view = new class {
            public $allclients;
        };
       $this->view->allclients = 20;
     */
    
    $testController = new \TestController;
    $aclMock = \Mockery::mock('overload:\User');
    $aclMock->shouldReceive('create')
        ->once()
        ->andThrow(new \Exception("wubalubadub"));
    $testController->view = new class {
        public function disable(){
            return true;
        }
    };
    $testController->request = new class {
        public function isPost(){
            return true;
        }
        public function getPost($arg){
            return 99;
        }
    };
    $resp = $testController->dbcheckAction();
    //print_r($resp);
    //
    // Making sure instead of throwing exception we get the error back
    $this->assertEquals(
        "wubalubadub",
        $resp->getMessage(),
        "Exception Handling works"
    );
    }

}
