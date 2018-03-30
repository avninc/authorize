<?php

namespace AVN\Authorize\Models;

use stdClassObject;
use AVN\Authorize\Models\LineItem;
use AVN\Authorize\Models\AbstractModel;

class LineItems extends AbstractModel
{
    protected $lineItems = null;

    public function attributeName() : string
    {
        return 'lineItems';
    }

    public function data()
    {
        $data = $this->lineItems;

        if(isset($data['lineItems'])) {
            $data = $data['lineItems'];
        }
        
        $list = [];
        if($data && count($data)) {
            foreach($data as $i => $item) {
                $list['lineItem'] = $item;
            }
        }

        return $list;
    }

    /**
     * Get the value of items
     */ 
    public function getLineItems()
    {
        return $this->lineItems;
    }

    /**
     * Set the value of items
     *
     * @return  self
     */ 
    public function setlineItems(array $items)
    {
        foreach($items as $item) {
            if(is_array($item)) {
                $item = new LineItem($item);
            }

            $this->addLineItem($item);
        }

        return $this;
    }

    /**
     * Set the value of items
     *
     * @return  self
     */ 
    public function addLineItem(LineItem $item)
    {
        $this->lineItems['lineItems'][] = $item->data();
        $this->data['lineItems'][] = $item->data();

        return $this;
    }
}