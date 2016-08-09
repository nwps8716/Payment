<?php

class HomeController extends Controller
{
    public function index()
    {
        $this->model("Bank");
        $crud = new Bank();

        if (isset($_POST['money'])) {
            $userId = $_POST['userid'];
            $status = $_POST['addorcut'];
            $postMoney = $_POST['money'];
            $oriMoney = $_POST['orimoney'];

            if ($oriMoney >= 0 and $status == 0) {
                $newCount = $oriMoney + $postMoney;
                $insert = $crud->insertDetails($userId, $status, $postMoney, $newCount);
                $compute = $crud->compute($userId, $newCount);
                $newRow = $crud->getUserData($userId);

                $this->view("index", $newRow);
            } elseif ($oriMoney >= $postMoney and $status == 1) {
                $newCount = $oriMoney - $postMoney;
                $insert = $crud->insertDetails($userId, $status, $postMoney, $newCount);
                $compute = $crud->compute($userId, $newCount);
                $newRow = $crud->getUserData($userId);

                $this->view("index", $newRow);
            }
        }
        $this->view("index");
    }

    public function show()
    {
        $this->model("Bank");
        $crud = new Bank();

        $userId = $_GET['userid'];

        $showArray = array();

        $row = $crud->getDetails($userId);
        $showArray["num"] = count($row);
        $showArray["row"] = $row;

        $this->view("show", $showArray);
    }
    
    public function signIn()
    {
        $this->model("Bank");
        $crud = new Bank();

        if (isset($_POST['userid'])) {
            $userId = $_POST['userid'];
            $row = $crud->getUserData($userId);

            $this->view("index", $row);
            exit;
        }
        $this->view("signin");
    }
}
