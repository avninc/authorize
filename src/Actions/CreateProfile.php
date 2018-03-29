<?php

namespace AVN\Authorize\Actions;

use AVN\Authorize\Actions\AbstractAction;

class CreateProfile extends AbstractAction
{
    public function attributeName() : string
    {
        return 'createCustomerProfileRequest';
    }
}
