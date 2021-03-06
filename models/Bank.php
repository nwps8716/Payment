<?php

require_once "../Payment/core/MyPdo.php";

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
        $sql = "SELECT * FROM `UserData` WHERE `userId` = :userId";
        $stmt = $this->dbcon->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();

        $result = $stmt->fetchAll();
        $this->dbpdo->closeConnection();
        $newData = [];
	    $newData['userId'] = $userId;
	    $newData['money'] = $result[0]['money'];

        return $newData;
    }

    //取出details of table的金額資料
    public function getDetails($userId)
    {
        $sql = "SELECT * FROM `Details` WHERE `userId` = :userId";
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

            $sql = "SELECT `money` FROM `UserData` WHERE `userId` = :userId FOR UPDATE";
            $stmt = $this->dbcon->prepare($sql);
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();

            $result = $stmt->fetchAll();
            $balance = $result[0]['money'];

            if ($balance < $postMoney and $status == 1) {
                throw new Exception('餘額不足');
            } elseif ($status == 1){
                $postMoney = -1 * $postMoney;
            }

            $sql = "UPDATE `UserData` SET `money` = `money` + :money WHERE `userId` = :userId";
            $stmt = $this->dbcon->prepare($sql);
            $stmt->bindValue(':money', $postMoney);
            $stmt->bindValue(':userId', $userId);
            $result = $stmt->execute();

            $sql = "SELECT `money` FROM `UserData` WHERE `userId` = :userId";
            $stmt = $this->dbcon->prepare($sql);
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();

            $result = $stmt->fetchAll();
    	    $balance = $result[0]['money'];
    	    $newData = [];
    	    $newData['userId'] = $userId;
    	    $newData['money'] = $result[0]['money'];

    	    $sql = "INSERT INTO `Details` (`userId`, `addOrCut`, `money`, `balance`)
                VALUES (:userId, :status, :postMoney, :balance)";
        	$stmt = $this->dbcon->prepare($sql);
        	$stmt->bindValue(':userId', $userId);
        	$stmt->bindValue(':status', $status);
        	$stmt->bindValue(':postMoney', $postMoney);
        	$stmt->bindValue(':balance', $balance);
        	$result = $stmt->execute();

        	$this->dbpdo->closeConnection();
    	    $this->dbcon->commit();

            return $newData;

        } catch (Exception $error) {
            $this->dbcon->rollBack();

            return $error->getMessage();
        }
    }
}
