<?php

class textCreator implements Creator{
    private $data = [];
    public $result;

    public function Creator(){
        if(isset($_SESSION['text'][$_POST['typeItem']]['id']) && $_SESSION['text'][$_POST['typeItem']]['id']!=""){
            $this->deleteTextField();
        }
        $this->addTextField();
    }

    public function deleteTextField(){
        $arr = [];
        $arr += ['id' => $_SESSION['text'][$_POST['typeItem']]['id']];
        $arr += ['origin' => $_SESSION['text'][$_POST['typeItem']]['origin']];
        $this->data = ['delete' => [0 => $arr]];
        $obj = new Items();
        $_SESSION['selected'] = "fields";
        $this->result = $obj->add($this->data);
    }

    public function addTextField(){
        $arr = [];
        if(isset($_POST['nameText']) && $_POST['nameText']!=""){
            $arr += ['name' => $_POST['nameText']];
        }
        else {
            $arr += ['name' => "no name"];
        }
        $arr += ['type' => 1];
        $arr += ['element_type' => $_POST['typeItem']];
        $arr += ['origin' => "origin".$arr['name']];
        $arr += ['is_editable' => 1];
        $this->data = ['add' => [0 => $arr]];
        $_SESSION['selected'] = "fields";
        $obj = new Items();
        $this->result = $obj->add($this->data);
        $_SESSION['text'][$_POST['typeItem']] = [
                                        'id' => $this->result['_embedded']['items'][0]['id'],
                                        'origin' => "origin".$arr['name']
            ];
    }
}