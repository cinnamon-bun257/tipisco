<?php 
session_start();
require 'config.php';

$_SESSION= array();

session_destroy();

header('Location: index.html');
exit ();