<?php

namespace AVN\Authorize\Messages;

use AVN\Authorize\Messages\Transaction;

class VoidTransaction extends Transaction
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->setTransactionType(static::VOID);
    }
}
