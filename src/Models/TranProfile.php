<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\AbstractModel;

class Profile extends AbstractModel
{
    protected $createProfile = 'true';

    public function attributeName() : string
    {
        return 'profile';
    }

    public function data()
    {
        $data = $this->data;

        if($this->createProfile) {
            $data['createProfile'] = $this->createProfile;
        }

        return $data;
    }

    /**
     * Get the value of createProfile
     */ 
    public function getCreateProfile()
    {
        return $this->createProfile;
    }

    /**
     * Set the value of createProfile
     *
     * @return  self
     */ 
    public function setCreateProfile($createProfile)
    {
        $this->createProfile = $createProfile;

        return $this;
    }
}