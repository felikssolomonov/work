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
            if(empty($_SESSION['contactList'])){
                $_SESSION['contactList'] = [];
            }
            if(empty($_SESSION['tasksId'])){
                $_SESSION['tasksId'] = [];
            }
        ?>
