<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\BillTo;

class ShipTo extends BillTo
{
    public function attributeName() : string
    {
        return 'shipTo';
    }
}