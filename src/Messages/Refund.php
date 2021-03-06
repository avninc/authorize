<?php

namespace AVN\Authorize\Messages;

use AVN\Authorize\Messages\Transaction;

class Refund extends Transaction
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->setTransactionType(static::REFUND);
    }
}
