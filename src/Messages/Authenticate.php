<?php

namespace AVN\Authorize\Messages;

use AVN\Authorize\Messages\AbstractMessage;

class Authenticate extends AbstractMessage
{
    public function attributeName() : string
    {
        return 'merchantAuthentication';
    }
}
