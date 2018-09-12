<?php

class View {

    function __construct() {
        //echo 'this is the view';
    }

    public function render($name, $noInclude = false)
    {
        require 'views/' . $name . '.php';    
    }

    public function gotoPage($pgName)
    {
        $pgName = URL . $pgName;
        echo "<script language=\"text/javascript\">window.location.href='" . $pgName . "';</script>";
    }
}