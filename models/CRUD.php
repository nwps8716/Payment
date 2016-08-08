<?php
class CRUD {
    
    public $dbcon;
    public $dbpdo;
    
    function __construct(){
        $this->dbpdo = new myPDO();
        $this->dbcon = $this->dbpdo->getConnection();
    }
    
    public function getuserdata(){
        $sql = "SELECT * FROM `userdata` WHERE `ID` = '1'";
        $stmt = $this->dbcon->prepare($sql);
        
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        $this->dbpdo->closeConnection();
	    
	    return $result;
    }
    
    public function insertdetails($userid,$addorcut,$money){
        $sql = "INSERT INTO `details`(`userid`, `AddorCut`, `money`) VALUES (:userid, :addorcut, :money) ";
    	$stmt = $this->dbcon->prepare($sql);
    	
    	$stmt->bindValue(':userid',$userid);
    	$stmt->bindValue(':addorcut',$addorcut);
    	$stmt->bindValue(':money',$money);
    	
    	
    	$result = $stmt->execute();
    	$result = $this->dbcon->lastInsertId();  //抓到最後一個activeID，丟給addmember使用
    	
    	$this->dbpdo->closeConnection();
    	
    	return $result;
    }
    
    
}
?>