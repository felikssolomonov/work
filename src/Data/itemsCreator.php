<?php

class itemsCreator implements Creator {
    private $nameContact;
    private $nameCustomer;
    private $nameLead;
    private $nameCompany;
    private $amount;

    private $data = [];
    private $arrayIdCompanies = [];
    private $arrayIdContacts = [];
    private $arrayIdLeads = [];
    private $arrayIdCustomers = [];
    private $result;

    private function setAmount(){
        if(!empty($_POST['amount'])){
            $this->amount = $_POST['amount'];
        }
        else{
            $this->amount = 1;
        }
    }
    private function setNameContact(){
        if(!empty($_POST['contact'])){
            $this->nameContact = $_POST['contact'];
        }
        else{
            $this->nameContact = NO_NAME;
        }
    }
    private function setNameCustomer(){
        if(!empty($_POST['customer'])){
            $this->nameCustomer = $_POST['customer'];
        }
        else{
            $this->nameCustomer = NO_NAME;
        }
    }
    private function setNameLead(){
        if(!empty($_POST['lead'])){
            $this->nameLead = $_POST['lead'];
        }
        else{
            $this->nameLead = NO_NAME;
        }
    }
    private function setNameCompany(){
        if(!empty($_POST['company'])){
            $this->nameCompany = $_POST['company'];
        }
        else{
            $this->nameCompany = NO_NAME;
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
        $this->setAmount();
        $this->setNameContact();
        $this->setNameCustomer();
        $this->setNameLead();
        $this->setNameCompany();

        $this->create_companies();
        $this->create_contacts();
        $this->create_leads();
        $this->create_customers();
    }

    private function create_companies(){
        $arr = [];
        for ($k = 0; $k<$this->amount; $k++){
            $arr += [$k => ['name' => $this->nameCompany.$k]];
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
                'name' => $this->nameContact.$k,
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
        $_SESSION['contactList'] = array_merge($_SESSION['contactList'], $array);
    }

    private function create_leads(){
        $arr = [];
        for ($k = 0; $k<$this->amount; $k++){
            $arr += [$k => [
                'name' => $this->nameLead.$k,
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
                'name' => $this->nameCustomer.$k,
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