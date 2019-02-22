<?php
header('Access-Control-Allow-Origin: *');

require_once ('class/Constants.php');
require_once ('class/CURL.php');

define("DOMAIN", 'fsolomonov3');
define("URL", 'https://' . DOMAIN . '.amocrm.ru/api/v2/');
define("USER", 'fsolomonov@team.amocrm.com');
define("HASH", 'd949d9d9d8b37147ddd3f3e5f3f9744163169b3c');
global $list_leads;
$list_leads = [];

$obj = new CURL();
$obj->auth();

if (isset($_REQUEST["ids"])) {
    $ids = $_REQUEST["ids"];

    global $idsContacts;
    $info = [];
    $limit_rows = 500;
    $limit_offset = 0;
    $flag = TRUE;
    $count = 0;
    $arr = explode(',', $ids);
    while(($count==$limit_rows) || ($flag==TRUE)) {
        $count = CURL::getAllIds('leads/?limit_rows='.$limit_rows.'&limit_offset='.$limit_offset, $arr);
        $limit_offset += $limit_rows;
        $flag = FALSE;
    }
    $line_out = "";
    $line_out .= 'lead, date, tags, custom_fields, contactsIDS, companyID&';
    $i = 0;
    foreach ($list_leads as $k=>$v) {
        $i = $k%6;
        switch ($i){
            case 0:
                $line_out .= $v.",";
                break;
            case 1:
                $line_out .= $v.",";
                break;
            case 2:
                $line_out .= $v.",";
                break;
            case 3:
                $line_out .= $v.",";
                break;
            case 4:
                $line_out .= $v.",";
                break;
            case 5:
                $line_out .= $v."&";
                break;
        }
    }
    echo $line_out;
}
