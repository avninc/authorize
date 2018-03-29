<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\AbstractModel;

class BillTo extends AbstractModel
{
    protected $firstName = null;
    protected $lastName = null;
    protected $company = null;
    protected $address = null;
    protected $city = null;
    protected $state = null;
    protected $zip = null;
    protected $country = null;
    protected $phoneNumber = null;
    protected $faxNumber = null;

    public function attributeName() : string
    {
        return 'billTo';
    }

    public function data()
    {
        $data = $this->data;

        $fields = ['firstName', 'lastName', 'company', 'address', 'city', 'state', 'zip', 'country', 'phoneNumber', 'faxNumber'];

        foreach($fields as $key) {
            if($this->{$key} !== null) {
                $data[$key] = $this->{$key};
            }
        }

        return $data;
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
     * Get the value of lastName
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of company
     */ 
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set the value of company
     *
     * @return  self
     */ 
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */ 
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of state
     */ 
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @return  self
     */ 
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the value of zip
     */ 
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set the value of zip
     *
     * @return  self
     */ 
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get the value of country
     */ 
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     * @return  self
     */ 
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get the value of phoneNumber
     */ 
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phoneNumber
     *
     * @return  self
     */ 
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get the value of faxNumber
     */ 
    public function getFaxNumber()
    {
        return $this->faxNumber;
    }

    /**
     * Set the value of faxNumber
     *
     * @return  self
     */ 
    public function setFaxNumber($faxNumber)
    {
        $this->faxNumber = $faxNumber;

        return $this;
    }
}