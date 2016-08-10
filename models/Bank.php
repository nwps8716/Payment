<?php

class Bank
{
    public $dbcon;
    public $dbpdo;

    public function __construct()
    {
        $this->dbpdo = new MyPdo();
        $this->dbcon = $this->dbpdo->getConnection();
    }

    public function getUserData($userId)
    {
        $sql = "SELECT * FROM `userdata` WHERE `userid` = :userId";
        $stmt = $this->dbcon->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();

        $result = $stmt->fetchAll();
        $this->dbpdo->closeConnection();

        return $result;
    }

    //將update完的金額資料存入資料表
    public function insertDetails($userId, $status, $postMoney, $balance)
    {
        $sql = "INSERT INTO `details` (`userid`, `addorcut`, `money`, `balance`)
                VALUES (:userId, :status, :postMoney, :balance)";
    	$stmt = $this->dbcon->prepare($sql);
    	$stmt->bindValue(':userId', $userId);
    	$stmt->bindValue(':status', $status);
    	$stmt->bindValue(':postMoney', $postMoney);
    	$stmt->bindValue(':balance', $balance);
    	$result = $stmt->execute();

    	$this->dbpdo->closeConnection();

    	return $result;
    }

    //取出details of table的金額資料
    public function getDetails($userId)
    {
        $sql = "SELECT * FROM `details` WHERE `userid` = :userId";
        $stmt = $this->dbcon->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();

        $result = $stmt->fetchAll();
        $this->dbpdo->closeConnection();

	    return $result;
    }

    public function compute($userId, $postMoney, $status)
    {
        try {
            $this->dbcon->beginTransaction();

            $sql = "SELECT `money` FROM `userdata` WHERE `userid` = :userId FOR UPDATE";
            $stmt = $this->dbcon->prepare($sql);
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();

            $result = $stmt->fetchAll();
            $balance = $result[0]['money'];

            if ($balance < $postMoney and $status == 1) {
                throw new Exception('餘額不足');
            }

            if ($status == 0) {
                $sql = "UPDATE `userdata` SET `money` = `money` + :money WHERE `userid` = :userId";
                $stmt = $this->dbcon->prepare($sql);
                $stmt->bindValue(':money', $postMoney);
                $stmt->bindValue(':userId', $userId);
                $result = $stmt->execute();

            } elseif ($balance >= $postMoney and $status == 1) {
                $sql = "UPDATE `userdata` SET `money` = `money` - :money WHERE `userid` = :userId";
                $stmt = $this->dbcon->prepare($sql);
                $stmt->bindValue(':money', $postMoney);
                $stmt->bindValue(':userId', $userId);
                $result = $stmt->execute();
            }

            $sql = "SELECT `money` FROM `userdata` WHERE `userid` = :userId";
            $stmt = $this->dbcon->prepare($sql);
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();

            $result = $stmt->fetchAll();
    	    $this->dbpdo->closeConnection();
    	    $this->dbcon->commit();

            return $result;

        } catch (Exception $error) {
            $this->dbcon->rollBack();
            echo $error->getMessage() . "<br>";
        }
    }
}
