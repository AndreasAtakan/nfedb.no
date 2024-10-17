<?php
/*******************************************************************************
* Copyright (C) Nordfjord EDB AS - All Rights Reserved                         *
*                                                                              *
* Unauthorized copying of this file, via any medium is strictly prohibited     *
* Proprietary and confidential                                                 *
* Written by Andreas Atakan <aca@geotales.io>, August 2024                     *
*******************************************************************************/

session_start();

require "init.php";

//

$stmt = $PDO->prepare("SELECT email, message, created_date FROM nfedb.\"Contact\" ORDER BY created_date DESC");
$stmt->execute();
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="no">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, minimum-scale=1, shrink-to-fit=no, user-scalable=no, target-densitydpi=medium-dpi" />
	<meta name="apple-mobile-web-app-capable" content="yes" />

	<title>&nbsp;</title>

	<!--link rel="icon" href="assets/logo.jpg" /-->

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

	<link rel="stylesheet" href="lib/fontawesome/css/all.min.css" />
	<!--script src="lib/fontawesome/js/all.min.js"></script-->

	<link rel="stylesheet" href="css/main.css" />

	<style type="text/css">

		:root {}

		main {}

	</style>
</head>
<body>

	<div class="modal fade" id="loadingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="loadingModalLabel">Laster inn</h5>
					<!--button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button-->
				</div>
				<div class="modal-body">
					<div class="spinner-border text-primary" role="status">
						<span class="visually-hidden">Laster inn...</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<main role="main" class="container g-5">
		<div id="alert_area"></div>

		<div class="row my-5">
			<div class="col">
				<table class="table table-striped" id="contact">
					<thead>
						<tr>
							<th scope="col">E-post</th>
							<th scope="col">Melding</th>
							<th scope="col">Dato</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($rows as $row) { ?>
							<tr>
								<td><?php echo $row['email']; ?></td>
								<td><?php echo str_replace("\n", "<br />", $row['message']); ?></td>
								<td><?php echo date_format(date_create($row['created_date']), "j M Y, H:i"); ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</main>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

	<script type="text/javascript" src="js/helper.js"></script>

	<script type="text/javascript">

		window.addEventListener("load", function() {
			//
		});

	</script>

</body>
</html>
