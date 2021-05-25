	<nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
		<a class="navbar-brand" href="acasa"><img src="./assets/img/logo.png" alt="logo"></a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="collapsibleNavbar">
			<ul class="navbar-nav">
				<li class="nav-item"><a href="acasa" class="nav-link">Acasă</a></li>
				<li class="nav-item"><a href="regulament" class="nav-link">Regulament</a></li>
				<li class="nav-item"><a href="organizatori" class="nav-link">Organizatori</a></li>
				<li class="nav-item"><a href="sponsori" class="nav-link">Sponsori</a></li>
				<li class="nav-item"><a href="noutati" class="nav-link">Noutăți</a></li>
				<li class="nav-item"><a href="participanti" class="nav-link">Participanți</a></li>
				<li class="nav-item"><a href="subiecte" class="nav-link">Subiecte</a></li>
				<li class="nav-item"><a href="rezultate" class="nav-link">Rezultate</a></li>
				<li class="nav-item"><a href="contact" class="nav-link">Contact</a></li>
			</ul>

			<ul class="nav navbar-nav ml-auto" style="padding-right: 30px;">
				<li class="nav-item">
					<?php if (isset($_SESSION["auth_user_first_name"]) && isset($_SESSION["auth_user_family_name"])) {
						echo "<span class='text-white'>{$_SESSION['auth_user_first_name']} {$_SESSION['auth_user_family_name']}</span> ";
						echo '<a class="nav-link" href="dashboard" style="padding:0;"><i class="fas fa-users-cog"></i>
						Administrare</a>';
						echo '<a class="nav-link" href="#" style="padding:0;" onclick="$(\'#logout-form\').submit()"><i class="fas fa-sign-out-alt"></i>
						Logout</a>';
					} else {
						echo '<a class="nav-link" href="#login" data-toggle="modal"><i class="fas fa-sign-in-alt"></i>
						Login</a>';
					} ?>
					<form method="POST" id="logout-form" action="../includes/logout.php">
						<input type="hidden" id="logout" name="logout">
					</form>
				</li>
			</ul>
		</div>
	</nav>

	<div class="modal" id="login">
		<div class="modal-dialog">
			<form method="POST" id="login-form">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Log in</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div class="modal-body">

						<div class="form-group">
							<label for="email">Email:</label>
							<input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
							<div class="invalid-feedback"></div>
						</div>

						<div class="form-group">
							<label for="password">Parola:</label>
							<input type="password" class="form-control" placeholder="Parola" id="password" name="password" required>
							<div class="invalid-feedback"></div>
						</div>

					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Închide</button>
						<button type="submit" class="btn btn-primary">Trimite</button>
					</div>
					<script>
						$("#login").submit(function(e) {
							var form = $(this);
							if (!e.isDefaultPrevented()) {
								$.post("../includes/login.php", {
										'email': $('#email').val(),
										'password': $('#password').val()
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