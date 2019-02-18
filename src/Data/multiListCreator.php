<?php


class multiListCreator implements Creator{
    private $data = [];
    public $result;
    public $idMultiList;
    private $dataUpdate = [];
    private $idsContacts;
    private $arrayEnums = [];

    public function create(){
        global $idsContacts;
        $idsContacts = [];
        $limit_rows = 500;
        $limit_offset = 0;
        $flag = TRUE;
        $list = [];
        $w = 0;
        while((count($list)==$limit_rows) || ($flag==TRUE)) {
            $list = itemsCreator::getAllIds('contacts/?limit_rows='.$limit_rows.'&limit_offset='.$limit_offset);
            $idsContacts = array_merge($idsContacts, $list);
            $limit_offset += $limit_rows;
            $flag = FALSE;
            $w++;
        }
        $this->idsContacts = $idsContacts;
        $arr = [];
        if(!empty($_POST['nameMulti'])){
            $arr += ['name' => $_POST['nameMulti']];
        }
        else {
            $arr += ['name' => NO_NAME];
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
        $selected = "account?with=custom_fields";
        $account = new CURL();
        $account = $account->send(NULL);
        foreach ($account['_embedded']['custom_fields']['contacts'][$this->idMultiList]['enums'] as $key => $value){
            array_push($this->arrayEnums, $key);
        }
        $selected = "contacts";
        $counter = 250;
        $amount = count($this->idsContacts);
        $it = floor($amount/$counter);
        for ($k = 0; $k<$it; $k++){
            $id = $k * $counter;
            $this->setData($id, $counter);
        }
        $id = $it * $counter;
        $counter = $amount%$counter;
        $this->setData($id, $counter);
    }

    private function setData($id, $counter){
        $arr = [];
        $obj = new CURL();
        for ($k = 0; $k<$counter; $k++, $id++){
            $arrValuesEnum = [];
            $randNums = rand(0, 10);
            if($randNums==0){
                continue;
            }
            for($i=0; $i<$randNums; $i++){
                $arrValuesEnum += [$i => $this->arrayEnums[rand(0, 9)]];
            }
            $arr += [$k => [
                'id' => $this->idsContacts[$id],
                'updated_at' => $_SERVER['REQUEST_TIME'],
                'custom_fields' => [
                    0 => [
                        'id' => $this->idMultiList,
                        'values' => $arrValuesEnum,
                    ]]]];
        }
        $this->dataUpdate['update'] = $arr;
        $this->result = $obj->send($this->dataUpdate);
    }
}