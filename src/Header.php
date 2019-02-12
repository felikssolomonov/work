<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Script</title>
</head>
<style>
    <?php include "../src/Style.css"; ?>
</style>
<script>
    <?php include "../src/Script.js"; ?>
</script>
<body <?php include "../src/Variables.php"; ?>>
    <div>
        <?php include "../src/App/Menu.php"; ?>
        <?php
            $obj = new Auth();
            $obj->login();
//        require_once "../src/Items/Items.php";
//            $obj = new Items();
//            $obj->Auth();
            if(!isset($_SESSION['$contactListG']) || empty($_SESSION['$contactListG'])){
                $_SESSION['$contactListG'] = [];
                echo "not isset";
            }
            else {
                echo "isset";
            }
            if(!isset($_SESSION['tasksId']) || empty($_SESSION['tasksId'])){
                $_SESSION['tasksId'] = [];
                echo "not isset";
            }
            else {
                echo "isset";
            }
        ?>
