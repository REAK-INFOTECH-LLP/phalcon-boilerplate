<?php

namespace Index;

/**
 * Class UnitTest
 */
class UnitTest extends \UnitTestCase {
    /*
        Simple Unit Test to Test Controller Logic
        Functions should be isolated from DB / Request, to have this working properly.
    */
    public function testsunittestfunctionTestCase() {
        $result = new \IndexController;
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
    */
    public function testsintegrationtestTestCase() {
        $response = $this->guzzle->post('index/integrationTest', array(), array(
            'data'  =>  '50',
        ));

        $this->assertEquals(
            $response->getBody()->getContents(),
            "60",
            "Ideal value received"
        );
    }

}
