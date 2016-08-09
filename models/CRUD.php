<?php

class CRUD 
{
    
    public $dbcon;
    public $dbpdo;
    
    function __construct()
    {
        $this->dbpdo = new myPDO();
        $this->dbcon = $this->dbpdo->getConnection();
    }

    public function getUserData()
    {
        $sql = "SELECT * FROM `userdata` WHERE `ID` = '1'";
        $stmt = $this->dbcon->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->dbpdo->closeConnection();
	    
	    return $result;
    }
    
    public function insertDetails($userid,$addorcut,$postmoney,$balance)
    {
        $sql = "INSERT INTO `details`(`userid`, `AddorCut`, `money`, `balance`) VALUES (:userid, :addorcut, :postmoney, :balance) ";
    	$stmt = $this->dbcon->prepare($sql);
    	
    	$stmt->bindValue(':userid',$userid);
    	$stmt->bindValue(':addorcut',$addorcut);
    	$stmt->bindValue(':postmoney',$postmoney);
    	$stmt->bindValue(':balance',$balance);
    	
    	$result = $stmt->execute();
    	$this->dbpdo->closeConnection();
    	
    	return $result;
    }
    
    public function compute($userid,$newcount)
    {
        
        try{
            $this->dbcon->beginTransaction();
            
            $sql = "SELECT `money` FROM `userdata` WHERE `userid` = :userid FOR UPDATE ";
            $stmt = $this->dbcon->prepare($sql);
    
            $stmt->bindValue(':userid', $userid);
            
            $stmt->execute();
            $result = $stmt->fetch();
            
            // sleep(5); 
            if($result['money'] >= 0) {
                $sql = "UPDATE `userdata` SET `money`=:money WHERE `userid`=:userid ";
                $stmt = $this->dbcon->prepare($sql);
                
                $stmt->bindValue(':money', $newcount);
                $stmt->bindValue(':userid', $userid);
                
                $result = $stmt->execute();
            }
    	    $this->dbpdo->closeConnection();
    	    $this->dbcon->commit();
    	    
    	    if($result) {
    	        return $result;
	        } else {
	            throw new Exception("你出錯了!");
	        }
	        
        }catch(Exception $error) {
            $pdo->rollBack();
            echo $error->getMessage();
        }
    }
    
    public function getDetails()
    {
        $sql = "SELECT * FROM `details` WHERE `userid` = '101'";
        $stmt = $this->dbcon->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->dbpdo->closeConnection();
	    
	    return $result;
    }
}
