<?php
$host='localhost';
$dbname='student-management';
$username='root';
//change if your mysql is different
$password="";
//change if your mysql a password
try{
    $pdo=new pdo("mysql:host=$host;dbname=$dbname; charset=utf8mb4",$username,$password);
    //set error mode to exception to catch issues easily
    $pdo->setattribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOEXception $e){
    die("database connection failed:".$e->getmessage());
}
?>