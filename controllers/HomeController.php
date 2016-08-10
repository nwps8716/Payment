<?php

class HomeController extends Controller
{
    public function selfpage()
    {
        $this->model("Bank");
        $crud = new Bank();

        if (isset($_POST['money'])) {
            $userId = $_POST['userId'];
            $status = $_POST['addOrCut'];
            $postMoney = $_POST['money'];
            $compute = $crud->compute($userId, $postMoney, $status);

            if (isset($compute)) {
                $newCount = $compute[0]['money'];
                $insert = $crud->insertDetails($userId, $status, $postMoney, $newCount);
            }
            $newRow = $crud->getUserData($userId);

            $this->view("selfpage", $newRow);
        }
        $this->view("selfpage");
    }

    public function show()
    {
        $this->model("Bank");
        $crud = new Bank();

        $userId = $_GET['userId'];
        $showArray = [];

        $row = $crud->getDetails($userId);
        $showArray["num"] = count($row);
        $showArray["row"] = $row;

        $this->view("show", $showArray);
    }

    public function index()
    {
        $this->model("Bank");
        $crud = new Bank();

        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];
            $row = $crud->getUserData($userId);
            $this->view("selfpage", $row);
            exit;
        }
        $this->view("index");
    }
}
