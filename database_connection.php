<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "ats_system_db";

$mysqli = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}
