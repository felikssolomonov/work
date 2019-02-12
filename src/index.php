<?php
session_start();
define('DIR', __DIR__);
spl_autoload_register(function ($class) {
    include DIR . '/'.$class.'.php';
});
include "../src/Header.php";
include "../src/App/Controller.php";
require_once "../src/Items/Items.php";
require_once "../src/Data/Creator.php";
require_once "../src/Data/itemsCreator.php";
require_once "../src/Data/multiListCreator.php";
require_once "../src/Data/notationCreator.php";
require_once "../src/Data/taskCreator.php";
require_once "../src/Data/textCreator.php";


global $selected;

if (isset($_GET['selected']) && $_GET['selected']!="") {
    $selected = $_GET['selected'];
    include "../src/Views/".$selected.".html";
    if ($_GET['selected'] == "taskCreator"){
        if(empty($_SESSION['tasksId'])){
            echo "список незавершенных задач пуст";
        }
        else {
            echo "список id незавершенных задач<pre>";
            var_dump($_SESSION['tasksId']);
            echo "</pre>";
        }
    }
}

if(isset($_POST['click'])){
    $obj = new Controller();
    $obj->loaderItems($selected, "Creator");
}

if(isset($_POST['destroy'])){
    session_destroy();
}

include "../src/App/Footer.php";
