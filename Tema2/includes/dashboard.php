<?php
if (!isset($_SESSION["auth_user_id"])) {
	header("Location: " . SITE_URL);
}
?>
<h1>Administrare</h1>

<ul class="nav nav-tabs">
	<li class="nav-item">
		<a class="nav-link active" data-toggle="tab" href="#results">Rezultate</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#news">Noutăți</a>
	</li>
</ul>

<div class="tab-content">
	<div id="results" class="container tab-pane active"><br>
		<div class="row">
			<h5 class="card-header">Rezultate</h5>
			<table class="table table-striped" id="results-table">
				<thead class="thead-dark">
					<tr>
						<th>Id</th>
						<th>Nume</th>
						<th>Email</th>
						<th>Nota [1]</th>
						<th>Nota [2]</th>
						<th>Nota [3]</th>
						<th>Media</th>
						<th></th>
					</tr>
				</thead>

				<?php
				require_once "config.php";
				require_once "utils.php";

				$connection = connect();

				if ($result = $connection->query("SELECT * FROM participants")) {
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_array()) {
							echo "<tr>";

							$score_1 = $row['participant_score_1'] ?? 0;
							$score_2 = $row['participant_score_2'] ?? 0;
							$score_3 = $row['participant_score_3'] ?? 0;

							$score_1 = sprintf("%.2f", $score_1);
							$score_2 = sprintf("%.2f", $score_2);
							$score_3 = sprintf("%.2f", $score_3);

							$average = sprintf("%.2f", ($score_1 + $score_2 + $score_3) / 3);

							echo "<td>{$row['participant_id']}</td>";
							echo "<td>" . $row['participant_first_name'] . " " . mb_strtoupper($row['participant_family_name'], 'UTF-8') . "</td>";
							echo "<td>{$row['participant_email']}</td>";
							echo "<td>$score_1</td>";
							echo "<td>$score_2</td>";
							echo "<td>$score_3</td>";
							echo "<td>$average</td>";
							echo '<td><button type="button" title="modifică" class="btn btn-success edit-result"><i class="far fa-edit"></i></button> <button type="button" title="șterge" class="btn btn-danger delete"><i class="fas fa-eraser"></i></button></td>';
							echo "</tr>";
						}
					}

					$result->free();
				}
				?>
			</table>
		</div>
	</div>
	<div id="news" class="container tab-pane"><br>
		<div class="row">
			<h5 class="card-header">Noutăți</h5>
			<div class="ml-auto"><button type="button" class="btn btn-primary add-news"><i class="fas fa-plus-square"></i> adaugă</button></div>
			<table class="table table-striped" id="news-table">
				<thead class="thead-dark">
					<tr>
						<th>Id</th>
						<th>Conținut</th>
						<th>Dată</th>
						<th>Autor</th>
						<th></th>
					</tr>
				</thead>
				<?php
				$connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

				if ($connection === false) {
					die("Eroare la conexiune: " . $connection->connect_error);
				}

				$connection->query("SET NAMES utf8");

				$sql = <<<h
SELECT n.news_id, n.news_content, n.news_date, u.user_first_name, u.user_family_name
FROM news AS n, users AS u
WHERE n.user_id = u.user_id;
h;

				if ($result = $connection->query($sql)) {
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_array()) {
							$date = date_format(date_create($row['news_date']), "d.m.Y H:i");
							echo "<tr>";
							echo "<td>{$row['news_id']}</td>";
							echo "<td>" . htmlspecialchars(prepare_content($row['news_content'])) . "</td>";
							echo "<td>$date</td>";
							echo "<td>{$row['user_first_name']} {$row['user_family_name']}</td>";
							echo '<td><button type="button" title="modifică" class="btn btn-success edit-news"><i class="far fa-edit"></i></button> <button type="button" title="șterge" class="btn btn-danger delete"><i class="fas fa-eraser"></i></button></td>';
							echo "</tr>";
						}
					}

					$result->free();
				}

				$connection->close();
				?>
			</table>
		</div>
	</div>
</div>

<div class="modal" id="results-modal">
	<div class="modal-dialog">
		<form method="POST" id="results-form" action="../includes/dashboard_results.php">
			<input type="hidden" name="result-id" id="result-id">

			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Rezultate pentru <span id="participant-name"></span></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<div class="form-group">
						<label for="problem-1">Nota la problema 1</label>
						<input type="number" class="form-control" placeholder="Nota la problema 1" id="problem-1" name="problem-1" required step="0.01" min="0" max="10">
					</div>

					<div class="form-group">
						<label for="problem-2">Nota la problema 2</label>
						<input type="number" class="form-control" placeholder="Nota la problema 2" id="problem-2" name="problem-2" required step="0.01" min="0" max="10">
					</div>

					<div class="form-group">
						<label for="problem-3">Nota la problema 3</label>
						<input type="number" class="form-control" placeholder="Nota la problema 3" id="problem-3" name="problem-3" required step="0.01" min="0" max="10">
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Închide</button>
					<button type="submit" class="btn btn-primary">Trimite</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="modal" id="news-modal">
	<div class="modal-dialog">
		<form method="POST" id="news-form" action="../includes/dashboard_news.php">
			<input type="hidden" name="news-id" id="news-id">
			<input type="hidden" name="news-action" id="news-action">

			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Noutate</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<div class="form-group">
						<label for="news-content">Conținut</label>
						<textarea class="form-control" rows="5" id="news-content" name="news-content"></textarea>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Închide</button>
					<button type="submit" class="btn btn-primary">Trimite</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="modal" id="delete-modal">
	<div class="modal-dialog">
		<form method="POST" id="delete-form">
			<input type="hidden" name="delete-id" id="delete-id">
			<input type="hidden" name="delete-object" id="delete-object">

			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Ștergem înregistrarea?</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- <div class="modal-body"></div> -->

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Nu</button>
					<button type="submit" class="btn btn-primary">Da</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.edit-result').on('click', function() {
			$('#results-modal').modal('show');
			$tr = $(this).closest('tr');
			var data = $tr.children("td").map(function() {
				return $(this).text();
			}).get();

			$('#result-id').val(data[0]);
			$('#participant-name').text(data[1]);
			$('#problem-1').val(data[3]);
			$('#problem-2').val(data[4]);
			$('#problem-3').val(data[5]);
		});

		$('.edit-news').on('click', function() {
			$('#news-modal').modal('show');
			$tr = $(this).closest('tr');
			var data = $tr.children("td").map(function() {
				return $(this).text();
			}).get();

			$('#news-id').val(data[0]);
			$('#news-content').text(data[1]);
			$('#news-action').val('edit');
		});

		$('.add-news').on('click', function() {
			$('#news-modal').modal('show');
			$('#news-action').val('add');
		});

		$('.delete').on('click', function() {
			$('#delete-modal').modal('show');
			$tr = $(this).closest('tr');
			var data = $tr.children("td").map(function() {
				return $(this).text();
			}).get();

			var table = $(this).closest('table');

			$('#delete-id').val(data[0]);
			if (table.attr("id") == "results-table") {
				$('#delete-object').val('result');
				$('#delete-form').attr("action", "../includes/dashboard_results.php");
			} else if (table.attr("id") == "news-table") {
				$('#delete-object').val('news');
				$('#delete-form').attr("action", "../includes/dashboard_news.php");
			}
		});
	});
</script>