<?php

class Task
{
    private $id, $empId, $sharedWithIds, $assignDate, $assignTime, $dueDate, $dueTime, $description;
    private $attachments, $progress, $notes;

    function __construct()
    {
        $this->sharedWithIds = array();
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
     * Get the value of empId
     */ 
    public function getEmpId()
    {
        return $this->empId;
    }

    /**
     * Set the value of empId
     *
     * @return  self
     */ 
    public function setEmpId($empId)
    {
        $this->empId = $empId;

        return $this;
    }

    /**
     * Get the value of sharedWithIds
     */ 
    public function getSharedWithIds()
    {
        return $this->sharedWithIds;
    }

    /**
     * Set the value of sharedWithIds
     *
     * @return  self
     */ 
    public function setSharedWithIds($strSharedWithIds)
    {
        $this->sharedWithIds = explode(',', $strSharedWithIds);

        return $this;
    }

    /**
     * Get the value of assignDate
     */ 
    public function getAssignDate()
    {
        return $this->assignDate;
    }

    /**
     * Set the value of assignDate
     *
     * @return  self
     */ 
    public function setAssignDate($assignDate)
    {
        $this->assignDate = $assignDate;

        return $this;
    }

    /**
     * Get the value of assignTime
     */ 
    public function getAssignTime()
    {
        return $this->assignTime;
    }

    /**
     * Set the value of assignTime
     *
     * @return  self
     */ 
    public function setAssignTime($assignTime)
    {
        $this->assignTime = $assignTime;

        return $this;
    }

    /**
     * Get the value of dueDate
     */ 
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set the value of dueDate
     *
     * @return  self
     */ 
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get the value of dueTime
     */ 
    public function getDueTime()
    {
        return $this->dueTime;
    }

    /**
     * Set the value of dueTime
     *
     * @return  self
     */ 
    public function setDueTime($dueTime)
    {
        $this->dueTime = $dueTime;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of attachments
     */ 
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Set the value of attachments
     *
     * @return  self
     */ 
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * Get the value of progress
     */ 
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * Set the value of progress
     *
     * @return  self
     */ 
    public function setProgress($progress)
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * Get the value of notes
     */ 
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set the value of notes
     *
     * @return  self
     */ 
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }
    
    public function deserialize($xmlData)
    {
        
    }
}