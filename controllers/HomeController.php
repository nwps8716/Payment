<?php

class HomeController extends Controller
{
    function index()
    {
        $this->model("Bank");
        $crud = new Bank();

        $row = $crud->getUserData();

        $oriMoney = $row[0]['money'];

        if (isset($_POST['money'])) {
            $userId = $_POST['userid'];
            $status = $_POST['addorcut'];
            $postMoney = $_POST['money'];

            if ($oriMoney >= 0 and $status == 0) {
                $newCount = $oriMoney + $postMoney;
                $insert = $crud->insertDetails($userId, $status, $postMoney, $newCount);
                $compute = $crud->compute($userId, $newCount);
                $newRow = $crud->getUserData();
                
                $this->view("index",$newRow);
            } elseif ($oriMoney >= $postMoney and $status == 1) {
                $newCount = $oriMoney - $postMoney;
                $insert = $crud->insertDetails($userId, $status, $postMoney, $newCount);
                $compute = $crud->compute($userId, $newCount);
                $newRow = $crud->getUserData();

                $this->view("index", $newRow);
            }
        }
        $this->view("index", $row);
    }

    function show()
    {
        $this->model("Bank");
        $crud = new Bank();

        $showArray = array();

        $row = $crud->getDetails();
        $showArray["num"] = count($row);
        $showArray["row"] = $row;

        $this->view("show", $showArray);
    }
}
