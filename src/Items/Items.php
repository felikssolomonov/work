<?php

class Items{
    private $data = [];
    private $username = "fsolomonov2";
    private $link;
    private $headers = ["Accept: application/json"];
    public function __construct(){
        //
    }
    public function optionsCURL(){
//        $this->__construct();
        $data = $this->getData();
        $link = $this->getLink();
        $headers = $this->getHeaders();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_USERAGENT, "amoCRM-API-client/1.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        if(isset($data)){
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname($_SERVER['DOCUMENT_ROOT']).'/firstprojectamocrm/src/App/cookie.txt');
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname($_SERVER['DOCUMENT_ROOT']).'/firstprojectamocrm/src/App/cookie.txt');
        $out = curl_exec($curl);
        curl_close($curl);
        return $result = json_decode($out,TRUE);
    }
    public function getHeaders(){
        return $this->headers;
    }
    public function getLink(){
        $this->link = "https://".$this->username.".amocrm.ru/api/v2/".$_SESSION['selected'];
        return $this->link;
    }
    public function getData(){
        return $this->data;
    }
    public function setData($data){
        $this->data = $data;
    }
//    public function getUsername(){
//        return $this->username;
//    }
    public function add($data){
        $this->setData($data);
        return $this->optionsCURL();
    }
    public function show($data){
        $this->setData($data);
        return $result = $this->optionsCURL();
//        $this->showInfo($result);
//        var_dump($result);
//        echo "<pre>";
//        var_dump($result);
//        echo "</pre>";
    }
    public function update($data){
        $this->setData($data);
        return $this->optionsCURL();
    }
    public function showInfo($arr){
        foreach ($arr as $key=>$value){
            if(is_array($value)){
                $this->showInfo($value);
            }
            else{
                echo $key." => ".$value."<br>";
            }
        }
    }
}