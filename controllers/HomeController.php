<?php

class HomeController extends Controller
{
    public function index()
    {
        $this->model("Bank");
        $crud = new Bank();

        if (isset($_POST['money'])) {
            $userId = $_POST['userId'];
            $status = $_POST['addOrCut'];
            $postMoney = $_POST['money'];
            $oriMoney = $_POST['oriMoney'];

            if ($oriMoney >= 0 and $status == 0) {
                $newCount = $oriMoney + $postMoney;
                $compute = $crud->compute($userId, $postMoney, $status);

                if ($compute == TRUE) {
                    $insert = $crud->insertDetails($userId, $status, $postMoney, $newCount);
                }
                $newRow = $crud->getUserData($userId);

                $this->view("index", $newRow);
            } elseif ($oriMoney >= $postMoney and $status == 1) {
                $newCount = $oriMoney - $postMoney;
                $compute = $crud->compute($userId, $postMoney, $status);

                if ($compute == TRUE) {
                    $insert = $crud->insertDetails($userId, $status, $postMoney, $newCount);
                }
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

        $userId = $_GET['userId'];
        $showArray = [];

        $row = $crud->getDetails($userId);
        $showArray["num"] = count($row);
        $showArray["row"] = $row;

        $this->view("show", $showArray);
    }

    public function signIn()
    {
        $this->model("Bank");
        $crud = new Bank();

        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];
            $row = $crud->getUserData($userId);
            $this->view("index", $row);
            exit;
        }
        $this->view("signin");
    }
}
