<?php

namespace AVN\Authorize\Messages;

use AVN\Authorize\Models\Profile as ProfileModel;
use AVN\Authorize\Messages\AbstractMessage;

class CreateProfile extends AbstractMessage
{
    protected $profile = null;
    protected $validationMode = null;

    public function __construct(array $data = [])
    {
        foreach($data as $key => $value) {
            $method = 'set' . ucwords($key);
            if(method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        $this->setData($this->data);
    }

    public function data()
    {
        return $this->sortedData();
    }

    public function attributeName() : string
    {
        return 'profile';
    }

    /**
     * Get the value of profile
     */ 
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set the value of profile
     *
     * @return  self
     */ 
    public function setProfile(ProfileModel $profile)
    {
        $this->profile = $profile->data();
        $this->data['profile'] = $profile->data();

        return $this;
    }

    /**
     * Get the value of validationMode
     */ 
    public function getValidationMode()
    {
        return $this->validationMode;
    }

    /**
     * Set the value of validationMode
     *
     * @return  self
     */ 
    public function setValidationMode($validationMode)
    {
        $this->validationMode = $validationMode;
        $this->data['validationMode'] = $validationMode;

        return $this;
    }
}
