<h1>Noutăți</h1>
<div class="list-group">
	<?php
	require_once "config.php";
	require_once "utils.php";

	$connection = connect();

	$sql = <<<h
SELECT news.news_content, news.news_date, users.user_first_name
FROM news, users
WHERE news.user_id = users.user_id
ORDER BY news.news_date DESC;
h;

	if ($result = $connection->query($sql)) {
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_array()) {
				$date = date_format(date_create($row['news_date']), "d.m.Y H:i");
				echo '<a href="#!" class="list-group-item list-group-item-action flex-column align-items-start">';
				echo '<div class="d-flex w-100 justify-content-between"><small class="text-muted">' . $date . '</small></div>';
				echo '<p class="mb-2">' . prepare_content($row['news_content']) . '</p><small class="text-muted">' . $row['user_first_name'] . '</small>';
				echo "</a>";
			}
		}

		$result->free();
	}

	$connection->close();
	?>
</div>