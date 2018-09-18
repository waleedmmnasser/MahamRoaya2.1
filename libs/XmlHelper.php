<?php

require 'models/Employee.php';
require 'models/Task.php';

class XmlHelper
{
    private static $empsDoc, $tasksDoc, $empsPath, $tasksPath;

    public static function loadData()
    {
        try
        {
            self::loadEmpsDoc(); self::loadTasksDoc();
        }
        catch(Exception $e)
        {

        }
    }

    private static function loadEmpsDoc()
    {
        try
        {
            //echo dirname(__FILE__) . '<br>'; 
            //print_r(glob('data/*.*')); echo '<br>';
            //echo dirname(dirname(__FILE__)) . '<br>';

            self::$empsDoc = new DOMDocument();

            if (file_exists("data/Employees.xml"))
            {
                self::$empsDoc->load("data/Employees.xml");

                //echo 'Employees successfully loaded';
            }
            else
                self::$empsDoc->loadXML("<Employees></Employees>");

            self::$empsPath = new DOMXPath(self::$empsDoc);
        }
        catch(Exception $e)
        {
            echo 'XmlHelper.loadEmpsDoc ERROR -- ' . $e->getMessage();
        }
    }

    private static function loadTasksDoc()
    {
        try
        {
            self::$tasksDoc = new DOMDocument();

            if (file_exists("data/EmployeesTasks.xml"))
                self::$tasksDoc->load("data/EmployeesTasks.xml");
            else
                self::$tasksDoc->loadXML("<EmployeesTasks></EmployeesTasks>");

            self::$tasksPath = new DOMXPath(self::$tasksDoc);
        }
        catch(Exception $e)
        {

        }
    }

    public static function authorizeUser($userName, $password)
    {
        try
        {
            //TODO: Add password check
            $empsElms = self::$empsPath->query("//Employees/Employee[@userName='" . $userName . "']");

            if ($empsElms->length > 0)
                return self::createEmployee($empsElms->item(0));
            else
                return null;
        }
        catch(Exception $e)
        {

        }
    }

    public static function getEmployees()
    {
        try
        {
            $employees = array();

            foreach(self::$empsDoc->getElementsByTagName('Employee') as $empElm)
            {
                //$emp = createEmployee($empElm);

                //$fnm = $empElm->getAttribute('firstName');
                //$ftnm = $empElm->getAttribute('fatherName');
                //$fmnm = $empElm->getAttribute('familyName');
                
                //$emp = new Employee($fnm, $ftnm, $fmnm);
                //$empId = $empElm->getAttribute('id'); $emp->setId($empId);
                //$emp->setNationalityId($empElm->getAttribute('natId'));

                //$subEmpsElms = self::$empsPath->query("//Employees/Employee[@managerId='" . $empId . "']");

                //$emp->setIsManager($subEmpsElms->length > 0);

                $employees[] = self::createEmployee($empElm);;
            }

            return $employees;
        }
        catch(Exception $e)
        {

        }
    }

    private static function createEmployee($empElm)
    {
        try
        {
            $fnm = $empElm->getAttribute('firstName');
            $ftnm = $empElm->getAttribute('fatherName');
            $fmnm = $empElm->getAttribute('familyName');
            
            $emp = new Employee($fnm, $ftnm, $fmnm);
            $empId = $empElm->getAttribute('id'); $emp->setId($empId);
            $emp->setNationalityId($empElm->getAttribute('natId'));
            
            if ($empElm->hasAttribute('managerId'))
                $emp->setManagerId($empElm->getAttribute('managerId'));

            $subEmpsElms = self::$empsPath->query("//Employees/Employee[@managerId='" . $empId . "']");

            $emp->setIsManager($subEmpsElms->length > 0);

            return $emp;
        }
        catch(Exception $e)
        {

        }
    }

    public static function getEmployee($empId)
    {
        try
        {
            $anEmpElm = self::$empsPath->query("//Employees/Employee[@id='" . $empId . "']");

            return self::createEmployee($anEmpElm->item(0));
        }
        catch(Exception $e)
        {

        }
    }

    public static function addEmployee()
    {
        try
        {

        }
        catch(Exception $e)
        {

        }
    }

    public static function updateEmployee()
    {
        try
        {

        }
        catch(Exception $e)
        {

        }
    }

    public static function getSubordinates($mgrId)
    {
        try
        {
            //echo '<br>Into getSubordinates...<br>';

            $subEmpsElms = self::$empsPath->query("//Employees/Employee[@managerId='" . $mgrId . "']");

            $subordinates = array();

            if ($subEmpsElms->length > 0)
            {
                //$emp = new Employee('(اختر أحد الموظفين)', '', ''); $emp->setId(0);
                //$subordinates[] = $emp;

                foreach($subEmpsElms as $empElm)
                {
                    $fnm = $empElm->getAttribute('firstName');
                    $ftnm = $empElm->getAttribute('fatherName');
                    $fmnm = $empElm->getAttribute('familyName');
                    
                    $emp = new Employee($fnm, $ftnm, $fmnm);
                    $emp->setId($empElm->getAttribute('id'));
                    $emp->setNationalityId($empElm->getAttribute('natId'));

                    $subordinates[] = $emp;
                }

                //var_dump($subordinates);

                return $subordinates;
            }
            else
                return null;
        }
        catch(Exception $e)
        {

        }
    }

    public static function addUser()
    {
        try
        {

        }
        catch(Exception $e)
        {

        }
    }

    public static function assignNewTask($newTask)
    {
        try
        {
            //echo "<br> Into assign: " .  $newTask->getEmpId();

            $empId = $newTask->getEmpId(); $empHasTasks = false;

            $empTasksElms = self::$tasksPath->query("//EmployeesTasks/EmployeeTasks[@empId=" . $empId . "]");

            //var_dump($empElms);

            //var_dump($empElms->item(0));

            $theEmpElm = null; $idPart = 0;

            if ($empTasksElms != null && $empTasksElms->item(0) != null)
            {
                //echo "<br>Getting last task id...";

                $theEmpElm = $empTasksElms->item(0);

                $empTasks = $theEmpElm->getElementsByTagName("Task");

                //echo "<br> Last: " . $empTasks->item($empTasks->length - 1)->getAttribute("id");

                if ($empTasks->length > 0)
                {
                    $lastTaskId = $empTasks->item($empTasks->length - 1)->getAttribute("id");
                    $idPart = intval(explode('.', $lastTaskId)[1]);
                }
            }
            else
            {
                //echo "<br>Creating element for emp...";

                $theEmpElm = self::$tasksDoc->createElement('EmployeeTasks');
                $theEmpElm->setAttribute("empId", $empId);
                self::$tasksDoc->documentElement->appendChild($theEmpElm);
            }
            
            //echo "<br>Creating task element...";

            $newId = $idPart + 1;
            $newTaskElm = self::$tasksDoc->createElement('Task');
            $newTaskElm->setAttribute('id', $empId . '.' . $newId);
            $newTaskElm->setAttribute('assignedOn', date('Y-n-j'));
            $newTaskElm->setAttribute('assignedAt', date('G:i:s'));
            $newTaskElm->setAttribute('dueDate', $newTask->getDueDate());
            $newTaskElm->setAttribute('dueTime', $newTask->getDueTime());

            $descElm = self::$tasksDoc->createElement('Description', $newTask->getDescription());
            $newTaskElm->appendChild($descElm);

            if (!is_null($newTask->getAttachments()))
            {
                $attachmentsElm = self::$tasksDoc->createElement('Attachments');

                foreach($newTask->getAttachments() as $attch)
                {
                    $attchElm = self::$tasksDoc->createElement('Attachment');
                    $attchElm->setAttribute('path', $attch->getPath());

                    $attachmentsElm->appendChild($attchElm);
                }

                $newTaskElm->appendChild($attachmentsElm);
            }

            $newTaskElm->appendChild(self::$tasksDoc->createElement('AssigneeNotes'));

            $prgElm = self::$tasksDoc->createElement('Progress'); $prgElm->setAttribute("val", "0");
            $newTaskElm->appendChild($prgElm);

            //echo "<br>Appending task to emp tasks...";

            $theEmpElm->appendChild($newTaskElm);

            //echo "<br>Saving doc...";

            self::$tasksDoc->save("data/EmployeesTasks.xml");
            
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public static function assignNewSharedTask($newTask)
    {
        try
        {
            //echo "<br> Into assign: " .  $newTask->getEmpId();

            $empId = $newTask->getEmpId(); $empHasTasks = false;

            $empTasksElms = self::$tasksPath->query("//EmployeesTasks/EmployeeTasks[@empId=" . $empId . "]");

            //var_dump($empElms);

            //var_dump($empElms->item(0));

            $theEmpElm = null; $idPart = 0;

            if ($empTasksElms != null && $empTasksElms->item(0) != null)
            {
                //echo "<br>Getting last task id...";

                $theEmpElm = $empTasksElms->item(0);

                $empTasks = $theEmpElm->getElementsByTagName("Task");

                //echo "<br> Last: " . $empTasks->item($empTasks->length - 1)->getAttribute("id");

                if ($empTasks->length > 0)
                {
                    $lastTaskId = $empTasks->item($empTasks->length - 1)->getAttribute("id");
                    $idPart = intval(explode('.', $lastTaskId)[1]);
                }
            }
            else
            {
                //echo "<br>Creating element for emp...";

                $theEmpElm = self::$tasksDoc->createElement('EmployeeTasks');
                $theEmpElm->setAttribute("empId", $empId);
                self::$tasksDoc->documentElement->appendChild($theEmpElm);
            }
            
            //echo "<br>Creating task element...";

            $newId = $idPart + 1;
            $newTaskElm = self::$tasksDoc->createElement('Task');
            $newTaskElm->setAttribute('id', $empId . '.' . $newId);
            $newTaskElm->setAttribute('assignedOn', date('Y-n-j'));
            $newTaskElm->setAttribute('assignedAt', date('G:i:s'));
            $newTaskElm->setAttribute('dueDate', $newTask->getDueDate());
            $newTaskElm->setAttribute('dueTime', $newTask->getDueTime());

            $descElm = self::$tasksDoc->createElement('Description', $newTask->getDescription());
            $newTaskElm->appendChild($descElm);

            if (!is_null($newTask->getAttachments()))
            {
                $attachmentsElm = self::$tasksDoc->createElement('Attachments');

                foreach($newTask->getAttachments() as $attch)
                {
                    $attchElm = self::$tasksDoc->createElement('Attachment');
                    $attchElm->setAttribute('path', $attch->getPath());

                    $attachmentsElm->appendChild($attchElm);
                }

                $newTaskElm->appendChild($attachmentsElm);
            }

            $newTaskElm->appendChild(self::$tasksDoc->createElement('AssigneeNotes'));

            $prgElm = self::$tasksDoc->createElement('Progress'); $prgElm->setAttribute("val", "0");
            $newTaskElm->appendChild($prgElm);

            //echo "<br>Appending task to emp tasks...";

            $theEmpElm->appendChild($newTaskElm);

            //echo "<br>Saving doc...";

            self::$tasksDoc->save("data/EmployeesTasks.xml");
            
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public static function addTaskNote($taskId, $note)
    {
        try
        {

        }
        catch(Exception $e)
        {

        }
    }

    public static function setTaskProgress($taskId, $progVal, $note)
    {
        try
        {

        }
        catch(Exception $e)
        {

        }
    }

    public static function setTaskEvaluation($taskId, $evaluation)
    {
        try
        {

        }
        catch(Exception $e)
        {

        }
    }

    public static function getEmployeeCurrentTasks($empId)
    {
        try
        {
            //echo "<br> Into. EmpId: " . $empId;

            $empTasksElms = self::$tasksPath->query("//EmployeesTasks/EmployeeTasks[@empId=" . $empId . "]");

            if ($empTasksElms != null && $empTasksElms->item(0) != null 
                    && $empTasksElms->item(0)->childNodes->length > 0)
            {
                //var_dump($empTasksElms->item(0));
                //echo "<br> --- <br>";
                $theTasksElms = $empTasksElms->item(0)->getElementsByTagName("Task");
                //var_dump($theTasksElms);

                //echo "<br> Found: " . $theTasksElms->length;

                $empTasks = array();

                foreach($theTasksElms as $taskElm)
                {
                    $taskPrg = 0;

                    $taskPrgElm = self::getXmlElm($taskElm, "Progress");
                    if ($taskPrgElm != null)
                        $taskPrg = $taskPrgElm->getAttribute("val");

                    if (strcmp($taskPrg, "100") != 0)
                        $empTasks[] = self::createTask($taskElm);
                }

                return $empTasks;
            }
            else
                return null;
        }
        catch(Exception $e)
        {

        }
    }

    public static function getEmployeeAllTasks($empId)
    {
        try
        {
            $empTasksElms = self::$tasksPath->query("//EmployeesTasks/EmployeeTasks[@empId=" . $empId . "]");

            if ($empTasksElms != null && $empTasksElms->item(0)->childNodes->length > 0)
            {
                //var_dump($empTasksElms->item(0));
                //echo "<br> --- <br>";
                $theTasksElms = $empTasksElms->item(0)->getElementsByTagName("Task");
                //var_dump($theTasksElms);

                //$theTasksElms = $empTasksElms->item(0)->childNodes;

                $empTasks = array();

                foreach($theTasksElms as $taskElm)
                {
                    /*
                    $taskPrgElm = self::getXmlElm($taskElm, "Progress");
                    $taskPrg = $taskPrgElm->getAttribute("val");

                    $aTask = new Task;

                    $aTask->setId($taskElm->getAttribute("id"));
                    $aTask->setAssignDate($taskElm->getAttribute("assignedOn"));
                    $aTask->setDueDate($taskElm->getAttribute("dueDate"));
                    $aTask->setDescription(self::getXmlElmVal($taskElm, "Description"));
                    $aTask->setProgress($taskPrg);
                    */
                    $empTasks[] = self::createTask($taskElm);
                }

                //echo "<br>From XmlHelper: " . count($empTasks);
                //var_dump($empTasks);

                return $empTasks;
            }
            else
                return null;
        }
        catch(Exception $e)
        {

        }
    }

    public static function getEmployeeDatedTasks($empId, $fromDate, $toDate)
    {
        try
        {
            $empTasksElms = self::$tasksPath->query("//EmployeesTasks/EmployeeTasks[@empId=" . $empId . "]");

            if ($empTasksElms != null && $empTasksElms->item(0)->childNodes->length > 0)
            {
                //var_dump($empTasksElms->item(0));
                //echo "<br> --- <br>";
                $theTasksElms = $empTasksElms->item(0)->getElementsByTagName("Task");
                //var_dump($theTasksElms);

                $fromDt = new DateTime($fromDate); $toDt = new DateTime($toDate);
                //$theTasksElms = $empTasksElms->item(0)->childNodes;

                $empTasks = array();

                foreach($theTasksElms as $taskElm)
                {
                    $aTask = self::createTask($taskElm);
                    $taskAssignDate = new DateTime($aTask->getAssignDate());
                    /*
                    $taskPrgElm = self::getXmlElm($taskElm, "Progress");
                    $taskPrg = $taskPrgElm->getAttribute("val");

                    $aTask = new Task;

                    $aTask->setId($taskElm->getAttribute("id"));
                    $aTask->setAssignDate($taskElm->getAttribute("assignedOn"));
                    $aTask->setDueDate($taskElm->getAttribute("dueDate"));
                    $aTask->setDescription(self::getXmlElmVal($taskElm, "Description"));
                    $aTask->setProgress($taskPrg);
                    */
                    if ($taskAssignDate >= $fromDt && $taskAssignDate <= $toDt)
                        $empTasks[] = $aTask;
                }

                //echo "<br>From XmlHelper: " . count($empTasks);
                //var_dump($empTasks);

                return $empTasks;
            }
            else
                return null;
        }
        catch(Exception $e)
        {

        }
    }

    private static function createTask($taskElm)
    {
        try
        {
            $taskPrgElm = self::getXmlElm($taskElm, "Progress");
            $taskPrg = $taskPrgElm->getAttribute("val");

            $sharedWithElm = self::getXmlElm($taskElm, "SharedWith");

            $aTask = new Task;

            $aTask->setId($taskElm->getAttribute("id"));
            $aTask->setAssignDate($taskElm->getAttribute("assignedOn"));
            $aTask->setDueDate($taskElm->getAttribute("dueDate"));
            $aTask->setDueTime($taskElm->getAttribute("dueTime"));
            $aTask->setDescription(self::getXmlElmVal($taskElm, "Description"));
            $aTask->setProgress($taskPrg);

            if ($sharedWithElm != null)
                $aTask->setSharedWithIds($sharedWithElm->getAttribute("otherEmps"));

            return $aTask;
        }
        catch(Exception $e)
        {

        }
    }

    private static function getXmlElm($parent, $tagName)
    {
        try
        {
            $xmlElms = $parent->getElementsByTagName($tagName);

            return ($xmlElms != null && $xmlElms->length > 0) ? $xmlElms[0] : null;
        }
        catch(Exception $e)
        {

        }
    }

    private static function getXmlElmVal($parent, $tagName)
    {
        try
        {
            return $parent->getElementsByTagName($tagName)[0]->nodeValue;
        }
        catch(Exception $e)
        {

        }
    }
}