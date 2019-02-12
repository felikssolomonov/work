<?php

class taskCreator implements Creator{
    private $data = [];
    public $result;

    public function Creator(){
        if(isset($_POST['option']) && $_POST['option']=="create"){
            echo "add";
            $this->add();
        }
        else if (isset($_POST['option']) && $_POST['option']=="update"){
            echo "update";
            $this->update();
        }
        else {
            echo "Такого просто не может быть, может быть где-то что-то сломалось...";
        }
    }

    public function update(){
        $arr = [];
        if(isset($_POST['text']) && $_POST['text']!=""){
            $arr += ['text' => $_POST['text']];
        }
        else {
            $arr += ['text' => "no text"];
        }
        $arr += ['id' => $_POST['id']];//is_completed
        $arr += ['is_completed' => 1];
        $arr += ['updated_at' => $_SERVER['REQUEST_TIME']];
        $this->data = ['update' => [0 => $arr]];
        $_SESSION['selected'] = "tasks";
        $obj = new Items();
        $this->result = $obj->add($this->data);
        if(($key = array_search($_POST['id'],$_SESSION['tasksId'])) !== FALSE){
            unset($_SESSION['tasksId'][$key]);
        }
    }

    public function add(){
        $arr = [];
        if(isset($_POST['text']) && $_POST['text']!=""){
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
        $_SESSION['selected'] = "tasks";
        $obj = new Items();
        $this->result = $obj->add($this->data);
        array_push($_SESSION['tasksId'], $this->result['_embedded']['items'][0]['id']);
//        echo "список id задач<pre>";
//        var_dump($_SESSION['tasksId']);
//        echo "</pre>";
    }
}