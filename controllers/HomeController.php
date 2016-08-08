<?php
class HomeController extends Controller {
    
    function index() {
        
        $this->model("CRUD");
        $crud = new CRUD();
        
        $showArray = Array();
        
        $row = $crud->getuserdata();
        
        $this->view("index",$row);
    }
}

?>
