<?php
session_start();
foreach ($_REQUEST as $index=>$value) {
	$_SESSION[$index]=$value;
}