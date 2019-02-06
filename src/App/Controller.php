<?php

class Controller{
    public function loaderItems($className, $funcName, $name = null){
        if (class_exists($className)){
            $obj = new $className();
            $obj->$funcName($name);
        }
    }
//    public function loaderViews($className, $funcName){
//        if (class_exists($className)){
//            $obj = new $className();
//            $obj->$funcName();
//        }
//    }
}