<?php
/**
 * 
 */
class Auth
{
    
    public static function handleLogin()
    {
        try
        {
            @session_start();

            //if (isset($_SESSION['loggedIn']))
            //{
                $isCheckingLogin = false;
                if (isset($_GET['url']))
                    $isCheckingLogin = $_GET['url'] == "login/run";
                    //echo "<br>Result: " . ($_GET['url'] == "login/run") . "<br>";

                $logged = $_SESSION[LOGGEDINFLAG];//$_SESSION['loggedIn7'];
                if ($logged == false && !$isCheckingLogin) {
                    session_destroy();

                    //echo "Must login first: " . URL;
                    require './controllers/login.php';
                    $loginContrl = new Login; $loginContrl->index();

                    exit();
                }
            //}
        }
        catch(Exception $e)
        {

        }
    }
    
}