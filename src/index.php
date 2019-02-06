<?php

session_start();

define('DIR', __DIR__);
spl_autoload_register(function ($class) {
    include DIR . '/'.$class.'.php';
});
include "../src/Header.php";
include "../src/App/Controller.php";
require_once "../src/Items/Items.php";
require_once "../src/Views/View.php";
require_once "../src/Views/ViewContacts.php";
require_once "../src/Views/ViewCompanies.php";
require_once "../src/Views/ViewCustomers.php";
require_once "../src/Views/ViewLeads.php";
require_once "../src/Data/Data.php";
require_once "../src/Data/DataContacts.php";
require_once "../src/Data/DataCompanies.php";
require_once "../src/Data/DataCustomers.php";
require_once "../src/Data/DataLeads.php";

if (isset($_GET['selected'])) {
        include "../src/Select.php";
}

if(isset($_POST['adder']) || isset($_SESSION['option'])){
    $obj = new Controller();
    if(isset($_GET['selected'])){
        $_SESSION['selected'] = $_GET['selected'];
    }
    if (isset($_POST['option'])){
        $_SESSION['option'] = $_POST['option'];
    }
    if(isset($_SESSION['option']) && $_SESSION['option']=='show'){
        $obj->loaderItems("Data".$_SESSION['selected'], $_SESSION['option']);
    }
    else {
        $obj->loaderItems("View".$_SESSION['selected'], $_SESSION['option']);
    }
}
if(isset($_POST['viewSend'])){
    if(isset($_SESSION['selected']) && isset($_SESSION['option'])){
        echo "class Data".ucfirst($_SESSION['selected'])."<br>";
        echo "method ".$_SESSION['option']."<br>";
        $obj = new Controller();
        $obj->loaderItems("Data".ucfirst($_SESSION['selected']), $_SESSION['option']);
    }
}

include "../src/App/Footer.php";
