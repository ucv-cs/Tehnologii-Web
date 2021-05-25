<h1>Participanți</h1>
<p>Te poți înscrie folosind <a class="nav-link" href="#signup" data-toggle="modal" style="display:inline;"><i class="fab fa-wpforms"></i> formularul</a></p>

<div class="modal" id="signup">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" id="signup-form" class="needs-validation">
				<div class="modal-header">
					<h4 class="modal-title">Înregistrează-te aici</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<div class="form-group">
						<label for="first-name">Prenume:</label>
						<input type="text" class="form-control" placeholder="Prenume" id="first-name" name="first-name" required pattern="[a-zA-Z\u00c0-\u021b]+[a-zA-Z\u00c0-\u021b-\s]+">
						<div class="invalid-feedback"></div>
					</div>

					<div class="form-group">
						<label for="family-name">Nume:</label>
						<input type="text" class="form-control" placeholder="Nume" id="family-name" name="family-name" required pattern="[a-zA-Z\u00c0-\u021b]+[a-zA-Z\u00c0-\u021b-\s]+">
						<div class="invalid-feedback"></div>
					</div>

					<div class="form-group">
						<label for="participant-email">Email:</label>
						<input type="email" class="form-control" placeholder="Email" id="participant-email" name="participant-email" required>
						<div class="invalid-feedback"></div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Închide</button>
					<button type="submit" class="btn btn-primary" id="send">Trimite</button>
					<script>
						$("#signup").submit(function(e) {
							var form = $(this);
							if (!e.isDefaultPrevented()) {
								$.post("../includes/signup.php", {
										'first-name': $('#first-name').val(),
										'family-name': $('#family-name').val(),
										'participant-email': $('#participant-email').val()
									},
									function(result) {
										result = JSON.parse(result);
										var counter = 0;
										for (const key in result) {
											if (result[key] != "") {
												counter++;
												$('#' + key + '+div.invalid-feedback').text(result[key]);
												$('#' + key).addClass('is-invalid');
											}
										}
										if (counter == 0) {
											location.reload();
										}
									});
								e.preventDefault();
							}
						});
					</script>
				</div>
			</form>
		</div>
	</div>
</div>

<p>Până acum s-au înscris următorii participanți:</p>

<?php
require_once "config.php";
require_once "utils.php";

$connection = connect();

if ($result = $connection->query("SELECT * FROM participants")) {
	if ($result->num_rows > 0) {
		echo "<ol>";
		while ($row = $result->fetch_array()) {
			echo "<li>{$row['participant_first_name']} " . mb_strtoupper($row['participant_family_name'], 'UTF-8') . "</li>";
		}
		echo "</ol>";
	}

	$result->free();
}

$connection->close();
