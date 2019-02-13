<?php
session_start();
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

if (!empty($_GET['selected'])) {
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
    $obj->loaderItems($selected, "create");
}

if(isset($_POST['destroy'])){
    session_destroy();
    echo "cleaning session";
}

include "../src/App/Footer.php";
