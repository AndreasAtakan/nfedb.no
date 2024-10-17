<?php
/*******************************************************************************
* Copyright (C) Nordfjord EDB AS - All Rights Reserved                         *
*                                                                              *
* Unauthorized copying of this file, via any medium is strictly prohibited     *
* Proprietary and confidential                                                 *
* Written by Andreas Atakan <aca@geotales.io>, September 2023                  *
*******************************************************************************/

ini_set("display_errors", "On"); ini_set("html_errors", 0); error_reporting(-1);

session_start();

require "init.php";

if(!isset($_REQUEST["op"])) { http_response_code(422); exit; }
$op = $_REQUEST["op"];



// Public API
if($op == "new_lead") {

	if(!isset($_POST["email"])
	|| !isset($_POST["message"])) { http_response_code(422); exit; }

	$email = htmlspecialchars($_POST["email"]);
	$message = htmlspecialchars($_POST["message"]);

	$stmt = $PDO->prepare("INSERT INTO nfedb.\"Contact\" (email, message) VALUES (?, ?)");
	$stmt->execute([$email, $message]);

	echo json_encode(array("status" => "success"));
	exit;

}

else
if($op == "__") {
	exit;
}

else { http_response_code(422); exit; }


exit;
