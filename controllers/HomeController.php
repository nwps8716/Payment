<?php

class HomeController extends Controller
{
    public function insertMoney()
    {
        $this->model('Bank');
        $modelsBank = new Bank();

        if (isset($_POST['money'])) {
            $userId = $_POST['userId'];
            $status = $_POST['addOrCut'];
            $postMoney = $_POST['money'];
            $compute = $modelsBank->compute($userId, $postMoney, $status);

            if (isset($compute)) {
                $newCount = $compute[0]['money'];
                $insert = $modelsBank->insertDetails($userId, $status, $postMoney, $newCount);
            }
            $newRow = $modelsBank->getUserData($userId);

            $this->view('insertMoney', $newRow);
        }

        $this->view('insertMoney');
    }

    public function showDetails()
    {
        $this->model('Bank');
        $modelsBank = new Bank();

        $userId = $_GET['userId'];
        $showArray = [];

        $row = $modelsBank->getDetails($userId);
        $showArray['num'] = count($row);
        $showArray['row'] = $row;

        $this->view('showDetails', $showArray);
    }

    public function signIn()
    {
        $this->model('Bank');
        $modelsBank = new Bank();

        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];
            $row = $modelsBank->getUserData($userId);
            $this->view('insertMoney', $row);
            exit;
        }

        $this->view('signIn');
    }
}
