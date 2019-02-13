<?php

class CURL{
    private $data = [];
    private $link;
    private $headers = ["Accept: application/json"];
    private $dataFormat;

    private function optionsCURL(){
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT, "amoCRM-API-client/1.0");
        curl_setopt($curl,CURLOPT_URL, $this->link);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname($_SERVER['DOCUMENT_ROOT']).'/firstprojectamocrm/src/App/cookie.txt');
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname($_SERVER['DOCUMENT_ROOT']).'/firstprojectamocrm/src/App/cookie.txt');
        if(!empty($this->dataFormat)){
            curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
            curl_setopt($curl,CURLOPT_POSTFIELDS, $this->dataFormat);
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
            curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        }
        $out = curl_exec($curl);
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);
        $code = (int)$code;
        $errors = [
            301 => 'Moved permanently',
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];
        try
        {
            if($code!=200 && $code!=204)
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
        }
        catch(Exception $E)
        {
            die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
        }
        $result = json_decode($out,TRUE);
        return $result;
    }

    private function getLink($url){
        global $selected;
        $this->link = PROTOCOL.SUB_DOMAIN.SITE.$url.$selected;
        return $this->link;
    }

    public function send($data){
        $this->link = $this->getLink(API_URL);
        $this->data = $data;
        if (!empty($this->data)){
            $this->dataFormat = http_build_query($this->data);
        }
        $result = $this->optionsCURL();
        return $result;
    }

    public function auth(){
        global $selected;
        $selected = "auth.php?type=json";
        $this->headers = ["Content-Type: application/json"];
        $this->link = $this->getLink(API_URL_PRIVATE);
        $this->data = [
            'USER_LOGIN'=>USER_LOGIN,
            'USER_HASH'=>USER_HASH,
        ];
        $this->dataFormat = json_encode($this->data);
        $result = $this->optionsCURL();
        $result = $result['response'];
        if(isset($result['auth'])){
            echo 'Авторизация прошла успешно<br>';
        }
        else {
            echo 'Авторизация не удалась<br>';
        }
        return $result;
    }
}