<?php

class Tasks extends Controller
{
    function __construct()
    {
        parent::__construct();    
    }

    public function index()
    {
        $this->view->title = 'صفحة المهام';

        //var_dump($_SESSION['CurrentEmp']);
        $crntEmp = $_SESSION['CurrentEmp'];

        $ownTasks = XmlHelper::getEmployeeCurrentTasks($crntEmp->getId());

        if ($ownTasks != null && count($ownTasks) > 0)
        {
            $ownTasksHtml = "";

            foreach($ownTasks as $aTask)
            {
                /*
                $taskId = $aTask->getId();
                $prgrsEdtr = "<input id='prgr" . $taskId . "' type='text' maxlength='3' size='3' value='" 
                            . $aTask->getProgress() . "' />";
                $notesEdtr = "<input id='note" . $taskId . "' type='text' maxlength='100' size='50' value='" 
                            . $aTask->getNotes() . "' />";
                $ownTasksHtml .= "<tr><td>" . $aTask->getDescription() . "</td>" .
                            "<td>" . $aTask->getAssignDate() . "</td>" .
                            "<td>" . $aTask->getDueDate() . "</td>" .
                            "<td style='width:30px'>" . $prgrsEdtr . "</td>" .
                            "<td style='width:80px'>" . $notesEdtr . "</td>" .
                            "</tr>";
                */
                $ownTasksHtml .= $this->createTaskRow($aTask);
            }
        }

        $this->view->empCrntTasks = $ownTasksHtml;

        $this->view->isManager = $crntEmp->getIsManager();
        
        if ($crntEmp->getIsManager())
        {
            //echo '<br>Getting employees...<br>';
            $this->view->subEmps = XmlHelper::getSubordinates($crntEmp->getId());

            //echo '<br>Got employees successfully<br>';
        }
        
        $this->view->render('header');
        $this->view->render('tasks/index');
        $this->view->render('footer');
    }

    public function getEmployeeCurrentTasks()
    {
        $crntEmp = $_SESSION['CurrentEmp'];
        $ownTasks = XmlHelper::getEmployeeCurrentTasks($crntEmp->getId());

        if ($ownTasks != null && count($ownTasks) > 0)
        {
            $ownTasksHtml = "";

            foreach($ownTasks as $aTask)
                $ownTasksHtml .= $this->createTaskRow($aTask);
        }

        $this->view->empCrntTasks = $ownTasksHtml;

        echo $ownTasksHtml;
    }

    public function getEmployeeAllTasks()
    {
        $crntEmp = $_SESSION['CurrentEmp'];
        $empTasks = XmlHelper::getEmployeeAllTasks($crntEmp->getId());

        //var_dump($empTasks);

        if ($empTasks != null && count($empTasks) > 0)
        {
            $allTasksHtml = "";

            foreach($empTasks as $emTk)
                $allTasksHtml .= $this->createTaskRow($emTk);
            
            echo $allTasksHtml;
        }
    }

    public function getEmployeeDatedTasks()
    {
        $fromDate = $_POST["fromDate"]; $toDate = $_POST["toDate"];
        $crntEmp = $_SESSION['CurrentEmp'];

        $empDatedTasks = XmlHelper::getEmployeeDatedTasks($crntEmp->getId(), $fromDate, $toDate);

        if (!is_null($empDatedTasks) && count($empDatedTasks) > 0)
        {
            $theTasks = "";

            foreach($empDatedTasks as $emTk)
                $theTasks .= $this->createTaskRow($emTk);
            
            echo $theTasks;
        }
    }

    public function getSubordinateCurrentTasks()
    {
        $empTasks = XmlHelper::getEmployeeCurrentTasks($empId);

        if (!is_null($empTasks) && $empTasks->length > 0)
        {
            foreach($empTasks as $emTk)
            {
                /*
                $taskId = $emTk->getId();
                $prgrsEdtr = "<input id='prgr" . $taskId . "' type='text' maxlength='3' value='" 
                            . $emTk->getProgress() . "' />";
                $notesEdtr = "<input id='note" . $taskId . "' type='text' maxlength='100' value='" 
                            . $emTk->getNotes() . "' />";
                $theTasks .= "<tr><td>" . $emTk->getDescription() . "</td>" .
                            "<td>" . $emTk->getAssignDate() . "</td>" .
                            "<td>" . $emTk->getDueDate() . "</td>" .
                            "<td>" . $prgrsEdtr . "</td>" .
                            "<td>" . $notesEdtr . "</td>" .
                            "<td><input id='delayTask'" . $taskId . "' type='button' /></td>" .
                            "<td><input id='delTask'" . $taskId . "' type='button' /></td>" .
                            "</tr>";
                */
                $theTasks .= $this->createTaskRow($emTk);
            }
            
            echo $theTasks;
        }
    }

    private function createTaskRow($aTask)
    {
        $taskId = $aTask->getId();
        $prgrsEdtr = "<input id='prgr" . $taskId . "' type='text' maxlength='3' size='2' value='" 
                    . $aTask->getProgress() . "' />";
        $notesEdtr = "<input id='note" . $taskId . "' type='text' maxlength='100' size='50' value='" 
                    . $aTask->getNotes() . "' />";
        $taskRow = "<tr><td>" . $aTask->getDescription() . "</td>" .
                    "<td>" . $aTask->getAssignDate() . "</td>" .
                    "<td>" . $aTask->getDueDate() . "</td>" .
                    "<td>" . $prgrsEdtr . "</td>" .
                    "<td>" . $notesEdtr . "</td>" .
                    //"<td><input id='delayTask'" . $taskId . "' type='button' /></td>" .
                    //"<td><input id='delTask'" . $taskId . "' type='button' /></td>" .
                    "</tr>";

        return $taskRow;
    }

    public function update()
    {
        try
        {

        }
        catch(Exception $e)
        {

        }
    }

    public function addNew()
    {
        try
        {

        }
        catch(Exception $e)
        {
            
        }
    }

    public function saveNew()
    {
        try
        {

        }
        catch(Exception $e)
        {
            
        }
    }
}