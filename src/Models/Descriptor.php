<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\AbstractModel;

class Descriptor extends AbstractModel
{
    protected $descriptor = null;

    public function attributeName() : string
    {
        return 'merchantDescriptor';
    }

    public function data()
    {
        $data = $this->data;

        if($this->descriptor) {
            $data['descriptor'] = $this->descriptor;
        }

        return $data;
    }

    /**
     * Get the value of descriptor
     */ 
    public function getDescriptor()
    {
        return $this->descriptor;
    }

    /**
     * Set the value of descriptor
     *
     * @return  self
     */ 
    public function setDescriptor($descriptor)
    {
        $this->descriptor = $descriptor;

        return $this;
    }
}