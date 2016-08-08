<?php
class HomeController extends Controller {
    
    function index() {
        $this->model("CRUD");
        $crud = new CRUD();
        
        $showArray = Array();
        
        $row = $crud->getuserdata();
        
        if(isset($_POST['money'])){
            $userid = $_POST['userid'];
            $money = $_POST['money'];
            $addorcut = $_POST['addorcut'];
            
            $compute = $crud->insertdetails($userid,$addorcut,$money);
        }
        
        $this->view("index",$row);
    }
    
}

?>
