<?php

namespace AVN\Authorize\Models;

use AVN\Authorize\Contracts\ModelContract;

abstract class AbstractModel implements ModelContract
{
    protected $data = [];
    
    public function __construct(array $data = [])
    {
        foreach($data as $key => $value) {
            $method = 'set' . ucwords($key);
            if(method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        
        $this->setData($data);
    }

    public function toJson($options=null)
    {
        return json_encode($this->data(), $options);
    }

    public function pretty()
    {
        return "\n\n". $this->toJson(JSON_PRETTY_PRINT) ."\n\n";
    }

    public function setData(array $data = [])
    {
        $this->data = $data;

        return $this;
    }

    public function data()
    {
        return [$this->attributeName() => $this->data];
    }
}