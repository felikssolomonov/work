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
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');
        if(!empty($this->dataFormat)){
            curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
            curl_setopt($curl,CURLOPT_POSTFIELDS, $this->dataFormat);
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
            curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        }
        $out = curl_exec($curl);
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);
        sleep(1);
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
        return $result;
    }

    public static function getAllIds($method, $arr){
        global $selected;
        $selected = $method;
        $account = new CURL();
        $list = $account->send(NULL);
        $count = 0;
        if (!empty($list['_embedded']['items'])) {
            foreach ($list['_embedded']['items'] as $key => $value) {
                $count++;
                if (in_array($value['id'], $arr)) {
                    global $list_leads;
                    array_push($list_leads, $value['name']);
                    array_push($list_leads, date('Y-m-d H:i:s', $value['created_at']));
                    $tags = "\"";
                    foreach ($value['tags'] as $k=>$v){
                        $tags .= $v['name']." ";
                    }
                    $tags .= "\"";
                    array_push($list_leads, $tags);
                    $custom = "\"";
                    foreach ($value['custom_fields'] as $k=>$v){
                        $custom .= $v['name'].":";
                        foreach ($v['values'] as $va){
                            $custom .= $va['value'].",";
                        }
                        $custom .= " ";
                    }
                    $custom .= "\"";
                    array_push($list_leads, $custom);
                    $contacts = "\"";
                    foreach ($value['contacts']['id'] as $k=>$v){
                        $contacts .= $v.",";
                    }
                    $contacts .= "\"";
                    array_push($list_leads, $contacts);
                    array_push($list_leads, $value['company']['id']);
                }
            }
        }
        return $count;
    }
}