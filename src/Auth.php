<?php

class Auth{
    public $subdomain='fsolomonov2'; #Наш аккаунт - поддомен
    public function login(){
        $user=array(
            'USER_LOGIN'=>'fsolomonov@team.amocrm.com', #Ваш логин (электронная почта)
            'USER_HASH'=>'69f0bfccfdb4f73adbccefe0f13cb75853649075' #Хэш для доступа к API (смотрите в профиле пользователя)
        );
        $link='https://'.$this->subdomain.'.amocrm.ru/private/api/auth.php?type=json';
        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        //
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($user));
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        //
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname($_SERVER['DOCUMENT_ROOT']).'/firstprojectamocrm/src/App/cookie.txt');
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname($_SERVER['DOCUMENT_ROOT']).'/firstprojectamocrm/src/App/cookie.txt');
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
        curl_close($curl); #Завершаем сеанс cURL
        $code=(int)$code;
        $errors=array(
            301=>'Moved permanently',
            400=>'Bad request',
            401=>'Unauthorized',
            403=>'Forbidden',
            404=>'Not found',
            500=>'Internal server error',
            502=>'Bad gateway',
            503=>'Service unavailable'
        );
        try
        {
            if($code!=200 && $code!=204)
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
        }
        catch(Exception $E)
        {
            die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
        }
        $Response=json_decode($out,true);
        $Response=$Response['response'];
        if(isset($Response['auth'])){ #Флаг авторизации доступен в свойстве "auth"
            echo 'Авторизация прошла успешно<br>';
        }
        else {
            echo 'Авторизация не удалась<br>';
        }
    }
    public function account(){
        $link='https://'.$this->subdomain.'.amocrm.ru/api/v2/account';
        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname($_SERVER['DOCUMENT_ROOT']).'/firstprojectamocrm/src/App/cookie.txt');
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname($_SERVER['DOCUMENT_ROOT']).'/firstprojectamocrm/src/App/cookie.txt');
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);
        $code=(int)$code;
        $errors=array(
            301=>'Moved permanently',
            400=>'Bad request',
            401=>'Unauthorized',
            403=>'Forbidden',
            404=>'Not found',
            500=>'Internal server error',
            502=>'Bad gateway',
            503=>'Service unavailable'
        );
        try
        {
            if($code!=200 && $code!=204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
            }
        }
        catch(Exception $E)
        {
            die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
        }
        $Response=json_decode($out,true);
//        $Response=$Response[0];
        return $out;
//        $this->showInfo($Response);
    }
    function showInfo($arr){
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