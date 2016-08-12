<?php

require_once "../Payment/myProject/Bank.php";

class BankTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUserData()
    {
        $userId = 101;

        $bank = new Bank();
        $result = $bank->getUserData($userId);

        $this->assertCount(2, $result);
        $this->assertEquals(101, $result['userId']);
        $this->assertEquals(16500, $result['money']);
    }

    public function testGetDetails()
    {
        $userId = 101;

        $bank = new Bank();
        $result = $bank->getDetails($userId);

        $this->assertCount(2, $result);
        $this->assertEquals(101, $result[0]['userId']);
        $this->assertEquals(0, $result[0]['addOrCut']);
        $this->assertEquals(200, $result[0]['money']);
        $this->assertEquals(16700, $result[0]['balance']);

        $this->assertEquals(101, $result[1]['userId']);
        $this->assertEquals(1, $result[1]['addOrCut']);
        $this->assertEquals(-200, $result[1]['money']);
        $this->assertEquals(16500, $result[1]['balance']);
    }

    public function testComputeAdd()
    {
        $userId = 101;
        $postMoney = 1000;
        $status = 0;

        $bank = new Bank();
        $result = $bank->compute($userId, $postMoney, $status);

        $this->assertCount(2, $result);
        $this->assertEquals(101, $result['userId']);
        $this->assertEquals(17500, $result['money']);
    }

    public function testComputeCut()
    {
        $userId = 101;
        $postMoney = 1000;
        $status = 1;

        $bank = new Bank();
        $result = $bank->compute($userId, $postMoney, $status);

        $this->assertCount(2, $result);
        $this->assertEquals(101, $result['userId']);
        $this->assertEquals(15500, $result['money']);
    }

    public function testComputeError()
    {
        $userId = 101;
        $postMoney = 18001;
        $status = 1;
        $expectedResult = "餘額不足";

        $bank = new Bank();
        $result = $bank->compute($userId, $postMoney, $status);

        $this->assertEquals($expectedResult, $result);
    }
}

