<?php
session_start();
require_once(dirname(__DIR__)) . "/php/class/email.php";
require_once(dirname(__DIR__)) . "/php/class/account.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cheqout.ini");
//grabbing both the account and email
$_SESSION["email"] = Email::getEmailIdByEmailAddress($pdo, $_POST['emailAddress']);
$_SESSION['account'] = Account::getAccountByEmailId($pdo, $_SESSION['email']->getEmailId());





