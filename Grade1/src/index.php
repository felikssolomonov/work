<?php

session_start();
ini_set('max_execution_time', 1200);
define('DIR', __DIR__);
spl_autoload_register(function ($class) {
    include DIR . '/'.$class.'.php';
});
include "../src/Header.php";
include "../src/App/Controller.php";
require_once "../src/Items/CURL.php";
require_once "../src/Data/Creator.php";
require_once "../src/Data/itemsCreator.php";
require_once "../src/Data/multiListCreator.php";
require_once "../src/Data/notationCreator.php";
require_once "../src/Data/taskCreator.php";
require_once "../src/Data/textCreator.php";

$obj = new CURL();
$obj->auth();

global $selected;
global $idsCompanies;
global $idsContacts;
global $idsCustomers;
global $idsLeads;
global $idsTasks;
global $idsTextFields;
global $ids;


if (!empty($_GET['selected'])) {
    echo $ids;
    $selected = $_GET['selected'];
    include "../src/Views/".$selected.".html";
    if ($_GET['selected'] == "sessionDestroy"){
        session_destroy();
        echo "cleaning session";
    }
    if ($_GET['selected'] == "taskCreator"){
        try {
            $idsTasks = itemsCreator::getAllIds('tasks');
        }
        catch (Exception $e){}
        if(empty($idsTasks)){
            echo "список незавершенных задач пуст<br>";
        }
        else {
            echo "список id незавершенных задач<br><pre>";
            var_dump($idsTasks);
            echo "</pre>";
        }
        $selected = $_GET['selected'];
    }
//    if (($_GET['selected'] == "notationCreator") || ($_GET['selected'] == "taskCreator")){
//        //это всё загнать в функцию
//        $idsContacts = itemsCreator::getAllIds('contacts');
//        if(empty($idsContacts)){
//            echo "список контактов пуст<br>";
//        }
//        else {
//            echo "список id контактов<br><pre>";
//            var_dump($idsContacts);
//            echo "</pre>";
//        }
//        //
//        $idsCompanies = itemsCreator::getAllIds('companies');
//        if(empty($idsCompanies)){
//            echo "список компаний пуст<br>";
//        }
//        else {
//            echo "список id компаний<br><pre>";
//            var_dump($idsCompanies);
//            echo "</pre>";
//        }
//        //
//        $idsCustomers = itemsCreator::getAllIds('customers');
//        if(empty($idsCustomers)){
//            echo "список покупателей пуст<br>";
//        }
//        else {
//            echo "список id покупателей<br><pre>";
//            var_dump($idsCustomers);
//            echo "</pre>";
//        }
//        //
//        $idsLeads = itemsCreator::getAllIds('leads');
//        if(empty($idsLeads)){
//            echo "список сделок пуст<br>";
//        }
//        else {
//            echo "список id сделок<br><pre>";
//            var_dump($idsLeads);
//            echo "</pre>";
//        }
//    }
//    $selected = $_GET['selected'];
}

if(isset($_POST['click'])){
    $obj = new Controller();
    $obj->loaderItems($selected, "create");
}

include "../src/App/Footer.php";
