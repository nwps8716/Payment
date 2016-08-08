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
}
?>