<?php

namespace Core;

class Container
{
    protected array $bindings = [];
    public function bind($key, $func){
        $this->bindings[$key] = $func;
    }

    public function run($key){
        if (!array_key_exists($key, $this->bindings)){
            throw new \Exception("$key does not exist");
        }
        return $this->bindings[$key]();
    }
}