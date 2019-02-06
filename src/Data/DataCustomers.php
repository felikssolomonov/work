<?php

class DataCustomers extends Data{
    public function __construct(){
        //
    }
    public function add(){
        echo "DataCustomers add";
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
        $arrD = [];
        if (isset($_POST['date'])){
            $this->date = $_POST['date'];
//            $arrD = ['next_date' => $this->date];
            $arrD = ['next_date' => strtotime($this->date)];
        }
        $arrN += $arrD;
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
//        print_r($this->data);
        echo "<pre>";
        var_dump($this->data);
        echo "</pre>";
        echo "<br>";
    }
    public function show(){
        echo "DataCustomers show";
    }
    public function update(){
        echo "DataCustomers update";
    }
}