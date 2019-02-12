<?php

//include "../../src/Variables.php";

class itemsCreator implements Creator {
    private $nameContact;
    private $nameCustomer;
    private $nameLead;
    private $nameCompany;
    private $date;
    private $number;

    private $data = [];
    private $arrayIdCompanies = [];
    private $arrayIdContacts = [];
    private $arrayIdLeads = [];
    private $arrayIdCustomers = [];
    static public $contactList = [];

    public $result;

    public function setNumber(){
        if(isset($_POST['number']) && $_POST['number']!=""){
            $this->number = $_POST['number'];
        }
        else{
            $this->number = 1;
        }
    }
    public function getNumber(){
        return $this->number;
    }

    public function setNameContact(){
        if(isset($_POST['contact']) && $_POST['contact']!=""){
            $this->nameContact = $_POST['contact'];
        }
        else{
            $this->nameContact = "no name";
        }
    }
    public function getNameContact(){
        return $this->nameContact;
    }

    public function setNameCustomer(){
        if(isset($_POST['customer']) && $_POST['customer']!=""){
            $this->nameCustomer = $_POST['customer'];
        }
        else{
            $this->nameCustomer = "no name";
        }
    }
    public function getNameCustomer(){
        return $this->nameCustomer;
    }

    public function setNameLead(){
        if(isset($_POST['lead']) && $_POST['lead']!=""){
            $this->nameLead = $_POST['lead'];
        }
        else{
            $this->nameLead = "no name";
        }
    }
    public function getNameLead(){
        return $this->nameLead;
    }

    public function setNameCompany(){
        if(isset($_POST['company']) && $_POST['company']!=""){
            $this->nameCompany = $_POST['company'];
        }
        else{
            $this->nameCompany = "no name";
        }
    }
    public function getNameCompany(){
        return $this->nameCompany;
    }

    public function setIdContact($res){
        for ($i = 0; $i<$this->number; $i++){
            array_push($this->arrayIdContacts, $res['_embedded']['items'][$i]['id']);
        }
        foreach ($this->arrayIdContacts as $key => $value){
            array_push($_SESSION['$contactListG'], $value);
        }
//        echo "<pre>";
//        echo "this<br>";
//        var_dump($_SESSION['$contactListG']);
//        echo "this";
//        echo "</pre>";
    }
    public function getIdContact(){
//        return $this->arrayIdContacts;
        return self::$contactList;
    }

    public function setIdCustomer($res){
        for ($i = 0; $i<$this->number; $i++){
            $this->arrayIdCustomers += [$i => $res['_embedded']['items'][$i]['id']];
        }
    }
    public function getIdCustomer(){
        return $this->arrayIdCustomers;
    }

    public function setIdLead($res){
        for ($i = 0; $i<$this->number; $i++){
            $this->arrayIdLeads += [$i => $res['_embedded']['items'][$i]['id']];
        }
    }
    public function getIdLead(){
        return $this->arrayIdLeads;
    }

    public function setIdCompany($res){
        for ($i = 0; $i<$this->number; $i++){
            $this->arrayIdCompanies += [$i => $res['_embedded']['items'][$i]['id']];
        }
    }
    public function getIdCompany(){
        return $this->arrayIdCompanies;
    }

    public function setDate(){
        if (isset($_POST['date']) && $_POST['date']!=""){
            $this->date = strtotime($_POST['date']);
        }
    }
    public function getDate(){
        return $this->date;
    }

    public function Creator(){
        $this->setNumber();
        $this->setNameContact();
        $this->setNameCustomer();
        $this->setNameLead();
        $this->setNameCompany();
        $this->setDate();

        $this->companiesCreator();
        $this->contactsCreator();
        $this->leadsCreator();
        $this->customersCreator();
    }

    public function companiesCreator(){
        $arr = [];
        for ($k = 0; $k<$this->number; $k++){
            $arr += [$k => ['name' => $this->getNameCompany().$k]];
        }
        $this->data['add'] = $arr;
        $_SESSION['selected'] = "companies";
        $obj = new Items();
        $this->result = $obj->add($this->data);
        $this->setIdCompany($this->result);
    }

    public function contactsCreator(){
        $arr = [];
        for ($k = 0; $k<$this->number; $k++){
            $arr += [$k => [
                'name' => $this->getNameContact().$k,
                'company_id' => $this->arrayIdCompanies[$k]
            ]];
        }
        $this->data['add'] = $arr;
        $_SESSION['selected'] = "contacts";
        $obj = new Items();
        $this->result = $obj->add($this->data);
        $this->setIdContact($this->result);
    }

    public function leadsCreator(){
        $arr = [];
        for ($k = 0; $k<$this->number; $k++){
            $arr += [$k => [
                'name' => $this->getNameLead().$k,
                'contacts_id' => [0 => $this->arrayIdContacts[$k]],
                'company_id' => $this->arrayIdCompanies[$k],
            ]];
        }
        $this->data['add'] = $arr;
        $_SESSION['selected'] = "leads";
        $obj = new Items();
        $this->result = $obj->add($this->data);
        $this->setIdLead($this->result);
    }

    public function customersCreator(){
        $arr = [];
        for ($k = 0; $k<$this->number; $k++){
            $arr += [$k => [
                'name' => $this->getNameLead().$k,
                'next_date' => $this->getDate(),
                'contacts_id' => [0 => $this->arrayIdContacts[$k]],
                'company_id' => $this->arrayIdCompanies[$k],
            ]];
        }
        $this->data['add'] = $arr;
        $_SESSION['selected'] = "customers";
        $obj = new Items();
        $this->result = $obj->add($this->data);
        $this->setIdCustomer($this->result);
    }
}