<?php
session_start();

if(!isset($_SESSION['fname']) || $_SESSION['approved'] == 0){
    header("Location: login.php");
}

$sfname = $_SESSION['fname'];
$slname = $_SESSION['lname'];
$admin = $_SESSION['admin'];
$blog = $_SESSION['blog'];



