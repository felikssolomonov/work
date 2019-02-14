<?php

class itemsCreator implements Creator {
    private $name_contact;
    private $name_customer;
    private $name_lead;
    private $name_company;
    private $amount;

    private $data = [];
    private $arrayIdCompanies = [];
    private $arrayIdContacts = [];
    private $arrayIdLeads = [];
    private $arrayIdCustomers = [];
    private $result;

    private function setPOSTValues(){
        $arr = ["company","contact","lead","customer",];
        foreach ($arr as $value){
            if(!empty($_POST[$value])){
                $this->{"name_".$value} = $_POST[$value];
            }
            else{
                $this->{"name_".$value} = NO_NAME;
            }
        }
        if(!empty($_POST['amount'])){
            $this->amount = $_POST['amount'];
        }
        else{
            $this->amount = 1;
        }
    }

    private function setIds($res){
        $array = [];
        for ($i = 0; $i<$this->amount; $i++){
            array_push($array, $res['_embedded']['items'][$i]['id']);
        }
        return $array;
    }

    public function create(){
        $this->setPOSTValues();

        $this->create_companies();
        $this->create_contacts();
        $this->create_leads();
        $this->create_customers();
    }
    public static function getAllIds($method){
        global $selected;
        $selected = $method;
        $account = new CURL();
        $list = $account->send(NULL);
        $listIds = [];
        if($selected == "tasks"){
            if(!empty($list['_embedded']['items'])){
                foreach ($list['_embedded']['items'] as $key => $value){
                    if(!$value['is_completed']){
                        array_push($listIds, $value['id']);
                    }
                }
            }
        }
        else {
            if(!empty($list['_embedded']['items'])){
                foreach ($list['_embedded']['items'] as $key => $value){
                    array_push($listIds, $value['id']);
                }
            }
        }
        return $listIds;
    }

    private function create_companies(){
        //array_chunk
        $arr = [];
        for ($k = 0; $k<$this->amount; $k++){
            $arr += [$k => ['name' => $this->name_company.$k]];
        }
        $this->data['add'] = $arr;
        global $selected;
        $selected = "companies";
        $obj = new CURL();
        $this->result = $obj->send($this->data);
        $array = $this->setIds($this->result);
        $this->arrayIdCompanies = array_merge($this->arrayIdCompanies, $array);
    }
    private function create_contacts(){
        $arr = [];
        for ($k = 0; $k<$this->amount; $k++){
            $arr += [$k => [
                'name' => $this->name_contact.$k,
                'company_id' => $this->arrayIdCompanies[$k]
            ]];
        }
        $this->data['add'] = $arr;
        global $selected;
        $selected = "contacts";
        $obj = new CURL();
        $this->result = $obj->send($this->data);
        $array = $this->setIds($this->result);
        $this->arrayIdContacts = array_merge($this->arrayIdContacts, $array);

//        $_SESSION['contactList'] = array_merge($_SESSION['contactList'], $array);
    }
    private function create_leads(){
        $arr = [];
        for ($k = 0; $k<$this->amount; $k++){
            $arr += [$k => [
                'name' => $this->name_lead.$k,
                'contacts_id' => [0 => $this->arrayIdContacts[$k]],
                'company_id' => $this->arrayIdCompanies[$k],
            ]];
        }
        $this->data['add'] = $arr;
        global $selected;
        $selected = "leads";
        $obj = new CURL();
        $this->result = $obj->send($this->data);
        $array = $this->setIds($this->result);
        $this->arrayIdLeads = array_merge($this->arrayIdLeads, $array);
    }
    private function create_customers(){
        $arr = [];
        for ($k = 0; $k<$this->amount; $k++){
            $arr += [$k => [
                'name' => $this->name_customer.$k,
                'next_date' => $_SERVER['REQUEST_TIME'],
                'contacts_id' => [0 => $this->arrayIdContacts[$k]],
                'company_id' => $this->arrayIdCompanies[$k],
            ]];
        }
        $this->data['add'] = $arr;
        global $selected;
        $selected = "customers";
        $obj = new CURL();
        $this->result = $obj->send($this->data);
        $array = $this->setIds($this->result);
        $this->arrayIdCustomers = array_merge($this->arrayIdCustomers, $array);
    }
}