<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\AbstractModel;

class Order extends AbstractModel
{
    protected $invoiceNumber = null;
    protected $description = null;

    public function attributeName() : string
    {
        return 'order';
    }

    public function data()
    {
        $data = $this->data;

        if($this->invoiceNumber) {
            $data['invoiceNumber'] = $this->invoiceNumber;
        }

        if($this->description) {
            $data['description'] = $this->description;
        }

        return $data;
    }

    /**
     * Get the value of invoiceNumber
     */ 
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * Set the value of invoiceNumber
     *
     * @return  self
     */ 
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
        $this->data['invoiceNumber'] = $invoiceNumber;

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
        $this->data['description'] = $description;

        return $this;
    }
}