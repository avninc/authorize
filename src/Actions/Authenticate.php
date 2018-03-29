<?php

namespace AVN\Authorize\Actions;

use AVN\Authorize\Actions\AbstractAction;

class Authenticate extends AbstractAction
{
    public function attributeName() : string
    {
        return 'authenticateTestRequest';
    }
}
