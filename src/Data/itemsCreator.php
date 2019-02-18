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
        foreach ($res['_embedded']['items'] as $key=>$value){
            array_push($array, $value['id']);
        }
        return $array;
    }

    public function create(){
        $this->setPOSTValues();
        $counter = 250;
        $it = floor($this->amount/$counter);//
        for ($k = 0; $k<$it; $k++){
            $id = $k * $counter;
            $this->create_companies($id, $counter);
            $this->create_contacts($id, $counter);
            $this->create_leads($id, $counter);
            $this->create_customers($id, $counter);
        }
        $id = $it * $counter;
        $counter = $this->amount%$counter;
        $this->create_companies($id, $counter);
        $this->create_contacts($id, $counter);
        $this->create_leads($id, $counter);
        $this->create_customers($id, $counter);
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

    private function create_companies($id, $counter){
        global $selected;
        $selected = "companies";
        $arr = [];
        for ($k = 0; $k<$counter; $k++, $id++){
            $arr += [$k => ['name' => $this->name_company.$id]];
        }
        $obj = new CURL();
        $this->data['add'] = $arr;
        $this->result = $obj->send($this->data);
        $array = $this->setIds($this->result);
        $this->arrayIdCompanies = array_merge($this->arrayIdCompanies, $array);
    }
    private function create_contacts($id, $counter){
        global $selected;
        $selected = "contacts";
        $arr = [];
        for ($k = 0; $k<$counter; $k++, $id++){
            $arr += [$k => [
                'name' => $this->name_contact.$id,
                'company_id' => $this->arrayIdCompanies[$id]
            ]];
        }
        $obj = new CURL();
        $this->data['add'] = $arr;
        $this->result = $obj->send($this->data);
        $array = $this->setIds($this->result);
        $this->arrayIdContacts = array_merge($this->arrayIdContacts, $array);
    }
    private function create_leads($id, $counter){
        global $selected;
        $selected = "leads";
        $arr = [];
        for ($k = 0; $k<$counter; $k++, $id++){
            $arr += [$k => [
                'name' => $this->name_lead.$id,
                'contacts_id' => [0 => $this->arrayIdContacts[$id]],
                'company_id' => $this->arrayIdCompanies[$id],
            ]];
        }
        $obj = new CURL();
        $this->data['add'] = $arr;
        $this->result = $obj->send($this->data);
        $array = $this->setIds($this->result);
        $this->arrayIdLeads = array_merge($this->arrayIdLeads, $array);
    }
    private function create_customers($id, $counter){
        global $selected;
        $selected = "customers";
        $arr = [];
        for ($k = 0; $k<$counter; $k++, $id++){
            $arr += [$k => [
                'name' => $this->name_customer.$id,
                'next_date' => $_SERVER['REQUEST_TIME'],
                'contacts_id' => [0 => $this->arrayIdContacts[$id]],
                'company_id' => $this->arrayIdCompanies[$id],
            ]];
        }
        $obj = new CURL();
        $this->data['add'] = $arr;
        $this->result = $obj->send($this->data);
        $array = $this->setIds($this->result);
        $this->arrayIdCustomers = array_merge($this->arrayIdCustomers, $array);
    }
}