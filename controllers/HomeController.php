<?php
class HomeController extends Controller {
    
    function index() {
        $this->model("CRUD");
        $crud = new CRUD();
        
        $row = $crud->getuserdata();
        
        $orimoney = $row[0]['money'];
        
        if (isset($_POST['money'])){
            $userid = $_POST['userid'];
            $addorcut = $_POST['addorcut'];
            $postmoney = $_POST['money'];
            
            $insert = $crud->insertdetails($userid,$addorcut,$postmoney);
            
            if ($addorcut == 0){
                $newcount = $orimoney + $postmoney;
                $compute = $crud->compute($userid,$newcount);
                $newrow = $crud->getuserdata();
                $this->view("index",$newrow);
                
            } else if ($addorcut == 1){
                $newcount = $orimoney - $postmoney;
                $compute = $crud->compute($userid,$newcount);
                $newrow = $crud->getuserdata();
                $this->view("index",$newrow);
            }
            
        }
        
        $this->view("index",$row);
    }
    
}

?>
