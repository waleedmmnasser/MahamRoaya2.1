<?php

class Login extends Controller {

    function __construct() {
        parent::__construct();    
    }
    
    function index() 
    {    
        $this->view->title = 'شاشة الدخول';
        
        $this->view->render('header');
        $this->view->render('login/index');
        $this->view->render('footer');
    }
    
    function run()
    {
        //echo "<br>Received: " . $fromForm . "<br>";
        //$this->model->run();
        //echo "<br>Into login.run: " . $_POST["login"] . " / " . $_POST["password"];
        $authUser = XmlHelper::authorizeUser($_POST["loginName"], $_POST["password"]);
        
        //if (strcmp($_POST["password"], "AbcXyz123") == 0)
        if ($authUser != null)
        {
            //echo $authUser->getFullName();

            $_SESSION['CurrentEmp'] = $authUser;  $_SESSION[LOGGEDINFLAG] = true;
            
            //$_SESSION['CurrentEmp']
            $this->view->crntEmpName = $authUser->getFullName();
            
            $this->view->gotoPage('tasks');
        }
        else
            echo "خطأ في بيانات الدخول";
    }
    

}