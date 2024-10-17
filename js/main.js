/*******************************************************************************
* Copyright (C) Nordfjord EDB AS - All Rights Reserved                         *
*                                                                              *
* Unauthorized copying of this file, via any medium is strictly prohibited     *
* Proprietary and confidential                                                 *
* Written by Andreas Atakan <aca@geotales.io>, September 2023                  *
*******************************************************************************/

"use strict";

function init() {

	$("span#ccYear").html( (new Date()).getFullYear() );

	$("form#form_contact").submit(ev => {
		ev.preventDefault();
		$("#loadingModal").modal("show");

		let vals = document.forms.form_contact.elements;
		let msg = vals.message.value, d = vals.date.value;
		if(d) { msg += `\nØnsket møte: ${d}, ${vals.time.value}`; }

		$.ajax({
			type: "POST",
			url: "/api.php",
			data: {
				"op": "new_lead",
				"email": vals.email.value,
				"message": msg
			},
			success: function(result, status, xhr) {
				$("#alert_area").html(`
					<div role="alert" class="alert alert-success alert-dismissible fade show">
						<strong>Takk for henvendelsen!</strong> Vi tar kontakt med deg igjen så snart som mulig
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				`);
			},
			error: function(xhr, status, error) {
				console.log(xhr.status, error);
				$("#alert_area").html(`
					<div role="alert" class="alert alert-danger alert-dismissible fade show">
						<strong>Feil:</strong> ${error}
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				`);
			},
			complete: function(xhr, status) { setTimeout(() => { $("#loadingModal").modal("hide"); }, 500); }
		});
	});

}
