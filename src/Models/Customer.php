<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\AbstractModel;

class Customer extends AbstractModel
{
    const INDIVIDUAL = 'individual';
    const BUSINESS = 'business';
    
    protected $type = null;
    protected $id = null;
    protected $email = null;

    public function attributeName() : string
    {
        return 'customer';
    }

    public function data()
    {
        $data = $this->data;

        $fields = ['type', 'id', 'email'];

        foreach($fields as $key) {
            if($this->{$key} !== null) {
                $data[$key] = $this->{$key};
            }
        }

        return $data;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
}