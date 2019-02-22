<?php

class textCreator implements Creator{
    private $data = [];
    public $result;
    private $arr = [
        1 => "contacts",
        2 => "leads",
        3 => "companies",
        12 => "customers",
    ];
    private $idField;

    public function create(){
        global $selected;
        $selected = "account?with=custom_fields";
        $account = new CURL();
        $account = $account->send(NULL);
        echo "list fields of ".$this->arr[$_POST['typeItem']]."<br>";
        foreach ($account['_embedded']['custom_fields'][
                            $this->arr[$_POST['typeItem']]
                    ] as $key=>$value){
            if($value['name']==TEXT_FIELD.$_POST['typeItem']){
                $this->idField = $key;
            }
        }
        if(empty($this->idField)){
            $this->addTextField();
        }
        $this->updateTextField();
    }

    public function updateTextField(){
        $arr = [];
        $arr += ['id' => $_POST['itemId']];
        $arr += ['updated_at' => $_SERVER['REQUEST_TIME']];
        $arr += ['custom_fields' => [
            0 => [
                'id' => $this->idField,
                'values' => [
                    0=> ['value' => $_POST['text']],
                ],
            ],
        ]];
        $this->data = ['update' => [0 => $arr]];
        $obj = new CURL();
        global $selected;
        $selected = $this->arr[$_POST['typeItem']];
        $this->result = $obj->send($this->data);
    }

    public function addTextField(){
        $arr = [];
        $arr += ['name' => TEXT_FIELD.$_POST['typeItem']];
        $arr += ['type' => 1];
        $arr += ['element_type' => $_POST['typeItem']];
        $arr += ['origin' => "origin".$_POST['typeItem']];
        $arr += ['is_editable' => 1];
        $this->data = ['add' => [0 => $arr]];
        global $selected;
        $selected = "fields";
        $obj = new CURL();
        $this->result = $obj->send($this->data);
        $this->idField = $this->result['_embedded']['items'][0]['id'];
    }
}