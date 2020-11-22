<?php
session_start();

if($_SESSION['logged'] !== true) {
    header("Location: /login.php");
}