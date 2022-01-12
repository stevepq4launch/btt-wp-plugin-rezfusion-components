<?php

namespace Rezfusion\Entity;

class LogEntry implements EntityInterface
{
    const FAIL_STATUS = 'fail';
    const SUCCESS_STATUS = 'success';
    private $id;
    private $message;
    private $date;
    private $status;

    public static function failStatus(): string
    {
        return static::FAIL_STATUS;
    }

    public static function successStatus(): string
    {
        return static::SUCCESS_STATUS;
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
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function toArray()
    {
        return [
            "id" => $this->getId(),
            "message" => $this->getMessage(),
            "status" => $this->getStatus(),
            "date" => $this->getDate()
        ];
    }
}
