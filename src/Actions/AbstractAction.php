<?php

namespace AVN\Authorize\Actions;

use AVN\Authorize\Contracts\ActionContract;

abstract class AbstractAction implements ActionContract
{
    protected $data = [];
    
    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    public function toJson($options=null)
    {
        return json_encode([$this->attributeName() => $this->data()], $options);
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
        return $this->data;
    }
}