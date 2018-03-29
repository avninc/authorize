<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\LineItem;
use AVN\Authorize\Models\AbstractModel;

class LineItems extends AbstractModel
{
    protected $items = null;

    public function attributeName() : string
    {
        return 'lineItems';
    }

    public function data()
    {
        $data = $this->data;

        if($this->items) {
            $data = $this->items;
        }

        return $data;
    }

    /**
     * Get the value of items
     */ 
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set the value of items
     *
     * @return  self
     */ 
    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Set the value of items
     *
     * @return  self
     */ 
    public function addItem(LineItem $item)
    {
        $this->items[] = $item->data();

        return $this;
    }
}