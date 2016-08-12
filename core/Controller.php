<?php

class Controller
{
    public function model($model)
    {
        require_once "core/MyPdo.php";
        require_once "models/$model.php";

        return new $model();
    }

    public function view($view, $data = array())
    {
        require_once "views/$view.php";
    }
}
