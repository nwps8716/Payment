<?php

class HomeController extends Controller {
    
    function index()
    {
        $this->model("CRUD");
        $crud = new CRUD();
        
        $row = $crud->getUserData();
        
        $orimoney = $row[0]['money'];
        
        if(isset($_POST['money'])) {
            $userid = $_POST['userid'];
            $addorcut = $_POST['addorcut'];
            $postmoney = $_POST['money'];
            
            if($orimoney >= 0 and $addorcut == 0) {
                $newcount = $orimoney + $postmoney;
                $insert = $crud->insertDetails($userid,$addorcut,$postmoney,$newcount);
                $compute = $crud->compute($userid,$newcount);
                $newrow = $crud->getUserData();
                $this->view("index",$newrow);
                
            } else if($orimoney >= $postmoney and $addorcut == 1) {
                $newcount = $orimoney - $postmoney;
                $insert = $crud->insertDetails($userid,$addorcut,$postmoney,$newcount);
                $compute = $crud->compute($userid,$newcount);
                $newrow = $crud->getUserData();
                $this->view("index",$newrow);
            }
        }
        $this->view("index",$row);
    }
    
    function show()
    {
        $this->model("CRUD");
        $crud = new CRUD();
        
        $showArray = Array();
        
        $row = $crud->getDetails();
        $showArray["num"] = count($row);
        $showArray["row"] = $row;
        
        $this->view("show",$showArray);
    }
}

?>
