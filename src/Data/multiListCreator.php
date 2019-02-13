<?php


class multiListCreator implements Creator{
    private $data = [];
    public $result;
    public $idMultiList;
    private $dataUpdate = [];

    public function create(){
        $arr = [];
        if(!empty($_POST['nameMulti'])){
            $arr += ['name' => $_POST['nameMulti']];
        }
        else {
            $arr += ['name' => "no name"];
        }
        $arr += ['type' => 5];
        $arr += ['element_type' => 1];
        $arr += ['origin' => "origin".$arr['name']];
        $strList = [];
        $pointer = 1;
        for ($k = 0; $k<10; $k++){
            if(!empty($_POST['list'][$k])){
                $strList += [$k => $_POST['list'][$k]];
            }
            else {
                $strList += [$k => "point".$pointer++];
            }
        }
        $arr += ['enums' => $strList];
        $this->data += ['add' => [0 => $arr]];
        global $selected;
        $selected = "fields";
        $obj = new CURL();
        $this->result = $obj->send($this->data);
        $this->idMultiList = $this->result['_embedded']['items'][0]['id'];
        $this->updateContact();
    }

    public function updateContact(){
        global $selected;
        $selected = "contacts";
        $account = new CURL();
        $list = $account->send(NULL);
        $listContacts = [];
        foreach ($list['_embedded']['items'] as $key => $value){
            array_push($listContacts, $value['id']);
        }
        $selected = "account?with=custom_fields";
        $account = new CURL();
        $account = $account->send(NULL);
        $arrayEnums = [];
        foreach ($account['_embedded']['custom_fields']['contacts'][$this->idMultiList]['enums'] as $key => $value){
            array_push($arrayEnums, $key);
        }
        $selected = "contacts";
        foreach ($listContacts as $key => $value){
            $arr = [];
            $arrValuesEnum = [];
            $randNums = rand(0, 10);
            if($randNums==0){
                continue;
            }
            for($i=0; $i<$randNums; $i++){
                $arrValuesEnum += [$i => $arrayEnums[rand(0, 9)]];
            }
            $arr += ['update' => [0 => ['id' => $value,
                                        'updated_at' => $_SERVER['REQUEST_TIME'],
                                        'custom_fields' => [
                                                    0 => [
                                                        'id' => $this->idMultiList,
                                                        'values' => $arrValuesEnum,
                                                    ]]]]];
            $this->dataUpdate = $arr;
            $obj = new CURL();
            $this->result = $obj->send($this->dataUpdate);
        }
    }
}