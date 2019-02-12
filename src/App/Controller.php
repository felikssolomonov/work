<?php

class Controller{
    public function loaderItems($className, $funcName){
        if (class_exists($className)){
            $obj = new $className();
            $obj->$funcName();
        }
    }
}