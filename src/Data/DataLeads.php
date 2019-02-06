<?php

class DataLeads extends Data{
    public function __construct(){
        //
    }
    public function add(){
        echo "DataLeads add";
        $this->data = [
            'add' => [
                0 => [
                    //
                ],
            ],
        ];
        $arrC = [];
        if(isset($_POST['tel'])){
            $tel = $_POST['tel']['address'];
            $j = [0 => $tel];
            $arr = ['id' => '225283', 'values' => $j];
            $this->custom_fields = [0 => $arr];
            $arrC = ['custom_fields' => $this->custom_fields];
        }
        $arrN = null;
        if (isset($_POST['name']) && $_POST['name']!=""){
            $this->setName($_POST['name']);
        }
        else {
            $this->setName("noname");
        }
        echo $this->getName();
        $arrN = ['name' => $this->getName()];
        $arrN += $arrC;
        $i = [0 => $arrN];
        $this->data['add'] = $i;
        if(isset($_POST['num']) && $_POST['num']>1){
            $k = $_POST['num'];
            echo "num > 1 : ".$k;
            for ($it=0; $it<$k; $it++){
                $obj = new Items();
                $obj->add($this->data);
            }
        }
        else {
            $obj = new Items();
            $obj->add($this->data);
        }
    }
    public function show(){
        echo "DataLeads show";
        //
        $obj = new Items();
        echo "<br>";
        echo $obj->getLink();
        echo "<br>";
        $obj->show();
    }
    public function update(){
        echo "DataLeads update";
    }
}