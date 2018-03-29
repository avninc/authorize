<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Models\AbstractModel;

class TrackData extends AbstractModel
{
    protected $track1 = null;
    protected $track2 = null;

    public function attributeName() : string
    {
        return 'trackData';
    }

    public function data()
    {
        $data = $this->data;

        if($this->track1) {
            $data['track1'] = $this->track1;
        }

        if($this->track2) {
            $data['track2'] = $this->track2;
        }

        return $data;
    }

    /**
     * Get the value of track1
     */ 
    public function getTrack1()
    {
        return $this->track1;
    }

    /**
     * Set the value of track1
     *
     * @return  self
     */ 
    public function setTrack1($track1)
    {
        $this->track1 = $track1;

        return $this;
    }

    /**
     * Get the value of track2
     */ 
    public function getTrack2()
    {
        return $this->track2;
    }

    /**
     * Set the value of track2
     *
     * @return  self
     */ 
    public function setTrack2($track2)
    {
        $this->track2 = $track2;

        return $this;
    }
}