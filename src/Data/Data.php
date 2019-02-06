<?php

abstract class Data{
    public $idUsers = 0;
    public $custom_fields;
    public $name = "";
    public $date;
    public $data = [];
    public function __construct(){
        //
    }
    public function add(){
        //
    }
    public function show(){
        //
    }
    public function update(){
        //
    }
    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
}