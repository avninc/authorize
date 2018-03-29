<?php

namespace AVN\Authorize\Messages;

use AVN\Authorize\Messages\Transaction;

class CompleteAuth extends Transaction
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->setTransactionType(static::COMPLETE_AUTH);
    }
}
