<?php


class multiListCreator implements Creator{
    private $data = [];
    public $result;
    public $idMultiList;
    private $dataUpdate = [];

    public function Creator(){
        $arr = [];
        if(isset($_POST['nameMulti']) && $_POST['nameMulti']!=""){
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
            if(isset($_POST['list'][$k]) && $_POST['list'][$k]!=""){
                $strList += [$k => $_POST['list'][$k]];
            }
            else {
                $strList += [$k => "point".$pointer++];
            }
        }
        $arr += ['enums' => $strList];
        $this->data += ['add' => [0 => $arr]];
        $_SESSION['selected'] = "fields";
        $obj = new Items();
        $this->result = $obj->add($this->data);
        $this->idMultiList = $this->result['_embedded']['items'][0]['id'];
        $this->updateContact();
    }

    public function updateContact(){
        $_SESSION['selected'] = "account?with=custom_fields";
        $account = new Items();
        $account = $account->show(null);
        $arrayEnums = [];
        foreach ($account['_embedded']['custom_fields']['contacts'][$this->idMultiList]['enums'] as $key => $value){
            array_push($arrayEnums, $key);
        }
        $_SESSION['selected'] = "contacts";
        foreach ($_SESSION['$contactListG'] as $key => $value){
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
            $obj = new Items();
            $this->result = $obj->add($this->dataUpdate);
//            echo "<b>result</b><br>";
//            echo "<pre><br>";
//            var_dump($this->result);
//            echo "</pre>";
//            echo "<b>data</b><br>";
//            echo "<pre><br>";
//            var_dump($this->dataUpdate);
//            echo "</pre>";
        }
    }
}