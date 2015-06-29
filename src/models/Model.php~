<?php

namespace UrbanBuz\API\models;

class Model
{

    public static function model($className)
    {
        return new $className;
    }

    public function fromJSON($data)
    {
        $data = json_decode($data);
        foreach ($data as $key => $val)
            $this->{$key} = $val;
        return $this;
    }
}
