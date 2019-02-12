<?php

class notationCreator implements Creator{
    private $data = [];
    public $result;

    public function Creator(){
        if(isset($_POST['option']) && $_POST['option']=="commonNotation"){
            $this->commonNotation();
        }
        if (isset($_POST['option']) && $_POST['option']=="incomingCall"){
            $this->incomingCall();
        }
    }

    public function incomingCall(){
        $arr = [];
        $arr += ['phone_number' => $_POST['phone']];
        $arr += ['direction' => "inbound"];
        $this->data = ['add' => [0 => $arr]];
        $_SESSION['selected'] = "calls/add";
        $obj = new Items();
        $this->result = $obj->add($this->data);
        if(isset($this->result['_embedded']['errors'])){
            echo "звонок не добавлен:<br>";
            echo $this->result['_embedded']['errors'][0]['msg'];
        }
        else{
            echo "звонок добавлен";
        }
    }

    public function commonNotation(){
        $arr = [];
        if(isset($_POST['text']) && $_POST['text']!=""){
            $arr += ['text' => $_POST['text']];
        }
        else {
            $arr += ['text' => "no text"];
        }
        $arr += ['note_type' => 4];
        $arr += ['element_type' => $_POST['typeItem']];
        $arr += ['element_id' => $_POST['id']];
        $this->data = ['add' => [0 => $arr]];
        $_SESSION['selected'] = "notes";
        $obj = new Items();
        $this->result = $obj->add($this->data);
    }
}