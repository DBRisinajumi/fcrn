<?php

class FcrnRateTest extends CTestCase {

    public function setUp() {
        $this->api = new ApiController(rand());
    }

    public function tearDown() {
        unset($this->api);
    }
    
    public function test_getRateFromBankRu(){
        $fcrn = new FcrnRate();
    }
}