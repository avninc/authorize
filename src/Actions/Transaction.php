<?php

namespace AVN\Authorize\Actions;

use AVN\Authorize\Actions\AbstractAction;

class Transaction extends AbstractAction
{
    public function attributeName() : string
    {
        return 'createTransactionRequest';
    }
}
