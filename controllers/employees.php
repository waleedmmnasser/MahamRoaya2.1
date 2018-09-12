<?php

class Employees extends Controller
{
    function __construct()
    {
        parent::__construct();    
    }

    function index() 
    {    
        $this->view->title = 'الموظفون';
        
        //echo '<br>Getting employees...<br>';
        $this->view->employees = XmlHelper::getEmployees();
        //echo '<br>Got employees successfully<br>';

        $this->view->render('header');
        $this->view->render('employees/index');
        $this->view->render('footer');
    }

    function run()
    {
        //$this->model->run();
    }
}