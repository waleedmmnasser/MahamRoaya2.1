<?php

class Employee
{
    private $id, $firstName, $fatherName, $familyName, $nationalityId, $birthDate, $jobId, $managerId,
            $isManager;

    public function __construct($firstName, $fatherName, $familyName)
    {
        $this->firstName = $firstName; $this->fatherName = $fatherName; $this->familyName = $familyName;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of firstName
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of fatherName
     */ 
    public function getFatherName()
    {
        return $this->fatherName;
    }

    /**
     * Set the value of fatherName
     *
     * @return  self
     */ 
    public function setFatherName($fatherName)
    {
        $this->fatherName = $fatherName;

        return $this;
    }

    /**
     * Get the value of familyName
     */ 
    public function getFamilyName()
    {
        return $this->familyName;
    }

    /**
     * Set the value of familyName
     *
     * @return  self
     */ 
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->fatherName . ' ' . $this->familyName;
    }

    /**
     * Get the value of nationalityId
     */ 
    public function getNationalityId()
    {
        return $this->nationalityId;
    }

    /**
     * Set the value of nationalityId
     *
     * @return  self
     */ 
    public function setNationalityId($nationalityId)
    {
        $this->nationalityId = $nationalityId;

        return $this;
    }

    /**
     * Get the value of birthDate
     */ 
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set the value of birthDate
     *
     * @return  self
     */ 
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get the value of jobId
     */ 
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * Set the value of jobId
     *
     * @return  self
     */ 
    public function setJobId($jobId)
    {
        $this->jobId = $jobId;

        return $this;
    }

    /**
     * Get the value of managerId
     */ 
    public function getManagerId()
    {
        return $this->managerId;
    }

    /**
     * Set the value of managerId
     *
     * @return  self
     */ 
    public function setManagerId($managerId)
    {
        $this->managerId = $managerId;

        return $this;
    }

    /**
     * Get the value of isManager
     */ 
    public function getIsManager()
    {
        return $this->isManager;
    }

    /**
     * Set the value of isManager
     *
     * @return  self
     */ 
    public function setIsManager($isManager)
    {
        $this->isManager = $isManager;

        return $this;
    }
}