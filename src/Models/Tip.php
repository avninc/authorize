<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\AbstractModel;

class Tip extends AbstractModel
{
    protected $tip = null;

    public function attributeName() : string
    {
        return 'tip';
    }

    public function data()
    {
        $data = $this->data;

        if($this->tip) {
            $data['tip'] = $this->descritiptor;
        }

        return $data;
    }

    /**
     * Get the value of tip
     */ 
    public function getTip()
    {
        return $this->tip;
    }

    /**
     * Set the value of tip
     *
     * @return  self
     */ 
    public function setTip($tip)
    {
        $this->tip = $tip;

        return $this;
    }
}