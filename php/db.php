<?php 
require 'libs/rb.php';
R::setup( 'mysql:host=localhost;dbname=friendly_hotel','root', '' ); 

if ( !R::testconnection() )
{
		exit ('Нет соединения с базой данных');
}

session_start();

$connection = mysqli_connect("localhost", "root", "", "friendly_hotel");
mysqli_query($connection, "SET NAMES 'utf8");
mysqli_query($connection, "SET CHARACTER SET 'utf8'");

