<h1>Rezultate</h1>
<ul class="list-group">
	<?php
	require_once "utils.php";
	$connection = connect();

	$sql = <<<h
SELECT participant_first_name, participant_family_name, participant_score_1, participant_score_2, participant_score_3, SUM(COALESCE(participant_score_1,0)+COALESCE(participant_score_2,0)+COALESCE(participant_score_3,0))/3 AS score
FROM participants
GROUP BY participant_id
ORDER BY score DESC
h;

	if ($result = $connection->query($sql)) {
		if ($result->num_rows > 0) {
			echo '<table class="table table-striped">';
			echo "<tr>";
			echo "<th>Loc</th>";
			echo "<th>Participant</th>";
			echo "<th>Nota [1]</th>";
			echo "<th>Nota [2]</th>";
			echo "<th>Nota [3]</th>";
			echo "<th>Media</th>";
			echo "</tr>";
			$counter = 1;
			while ($row = $result->fetch_array()) {
				echo "<tr>";

				$score_1 = $row['participant_score_1'] ?? 0;
				$score_2 = $row['participant_score_2'] ?? 0;
				$score_3 = $row['participant_score_3'] ?? 0;

				$score_1 = sprintf("%.2f", $score_1);
				$score_2 = sprintf("%.2f", $score_2);
				$score_3 = sprintf("%.2f", $score_3);

				$average = sprintf("%.2f", ($score_1 + $score_2 + $score_3) / 3);
				$name = $row['participant_first_name'] . " " . mb_strtoupper($row['participant_family_name'], 'UTF-8');

				echo "<td>$counter</td>";
				echo "<td>$name</td>";
				echo "<td>$score_1</td>";
				echo "<td>$score_2</td>";
				echo "<td>$score_3</td>";
				echo "<td><b>$average</b></td>";
				echo "</tr>";

				$counter++;
			}

			echo "</table>";
		}

		$result->free();
	}
	$connection->close();
	?>
</ul>