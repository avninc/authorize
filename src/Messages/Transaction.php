<?php

namespace AVN\Authorize\Messages;

use AVN\Authorize\Messages\AbstractMessage;

class Transaction extends AbstractMessage
{
    public function __construct(array $data = [])
    {
        foreach($data as $key => $value) {
            $method = 'set' . ucwords($key);
            if(method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        if(!$this->getTransactionType()) {
            $this->setTransactionType(static::CAPTURE);
        }

        if(!$this->getAmount()) {
            //$this->setAmount('0.00');
        }

        $this->setData($this->data);
    }

    public function attributeName() : string
    {
        return 'transactionRequest';
    }

    public function data()
    {
        // Build the data
        $data = $this->data;

        $this->setData($data);

        return parent::data();
    }
}
