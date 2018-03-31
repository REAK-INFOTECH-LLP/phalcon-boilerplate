<?php

namespace Index;

/**
 * Class UnitTest
 */
class UnitTest extends \UnitTestCase
{
    public function testsunittestfunctionTestCase()
    {
        $result = new \IndexController;
        $result = $result->unitTest();
        $this->assertEquals(
            $result,
            "ThisWorks",
            "This is OK"
        );
    }
}
