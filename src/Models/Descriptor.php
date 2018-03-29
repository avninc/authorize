<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\AbstractModel;

class Descriptor extends AbstractModel
{
    protected $merchantDescriptor = null;

    public function attributeName() : string
    {
        return 'merchantDescriptor';
    }
}