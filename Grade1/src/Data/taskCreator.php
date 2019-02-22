<?php

class taskCreator implements Creator{
    private $data = [];
    public $result;

    public function create(){
        if(isset($_POST['option']) && $_POST['option']=="create"){
            $this->add();
        }
        else if (isset($_POST['option']) && $_POST['option']=="update"){
            $this->update();
        }
        else {
            echo "Такого просто не может быть, может быть где-то что-то сломалось...";
        }
    }

    public function update(){
        $arr = [];
        if(!empty($_POST['text'])){
            $arr += ['text' => $_POST['text']];
        }
        else {
            $arr += ['text' => "no text"];
        }
        $arr += ['id' => $_POST['id']];
        $arr += ['is_completed' => 1];
        $arr += ['updated_at' => $_SERVER['REQUEST_TIME']];
        $this->data = ['update' => [0 => $arr]];
        global $selected;
        $selected = "tasks";
        $obj = new CURL();
        $this->result = $obj->send($this->data);
    }

    public function add(){
        $arr = [];
        if(!empty($_POST['text'])){
            $arr += ['text' => $_POST['text']];
        }
        else {
            $arr += ['text' => "no text"];
        }
        $arr += ['task_type' => $_POST['typeTask']];
        $arr += ['element_type' => $_POST['typeItem']];
        $arr += ['element_id' => $_POST['id']];
        $arr += ['complete_till' => $_SERVER['REQUEST_TIME']];
        $this->data = ['add' => [0 => $arr]];
        global $selected;
        $selected = "tasks";
        $obj = new CURL();
        $this->result = $obj->send($this->data);
//        array_push($_SESSION['tasksId'], $this->result['_embedded']['items'][0]['id']);
    }
}