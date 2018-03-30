<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\AbstractModel;

class LineItem extends AbstractModel
{
    protected $itemId = null;
    protected $name = null;
    protected $description = null;
    protected $quantity = null;
    protected $unitPrice = null;
    protected $taxable = null;

    public function attributeName() : string
    {
        return 'lineItem';
    }

    public function data()
    {
        $data = $this->data;

        $fields = ['itemId', 'name', 'description', 'quantity', 'unitPrice', 'taxable'];

        foreach($fields as $key) {
            if($this->{$key} !== null) {
                $data[$key] = $this->{$key};
            }
        }

        return $data;
    }

    /**
     * Get the value of itemId
     */ 
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set the value of itemId
     *
     * @return  self
     */ 
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
        $this->data['itemId'] = $itemId;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;
        $this->data['name'] = $name;

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

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->data['quantity'] = $quantity;

        return $this;
    }

    /**
     * Get the value of unitPrice
     */ 
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set the value of unitPrice
     *
     * @return  self
     */ 
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
        $this->data['unitPrice'] = $unitPrice;

        return $this;
    }

    /**
     * Get the value of taxable
     */ 
    public function getTaxable()
    {
        return $this->taxable;
    }

    /**
     * Set the value of taxable
     *
     * @return  self
     */ 
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
        $this->data['taxable'] = $taxable;

        return $this;
    }
}