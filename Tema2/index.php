<?php
require_once "./includes/config.php";

$page = isset($_GET["page"]) ? $_GET["page"] : "acasa";
$path = "./includes";

// asocieri: nume de pagină (slug) : titlu
$pages = array(
	"acasa" => "Pagina principală",
	"regulament" => "Regulament",
	"organizatori" => "Organizatori",
	"sponsori" => "Sponsori",
	"noutati" => "Noutăți",
	"participanti" => "Participanți",
	"subiecte" => "Subiecte",
	"rezultate" => "Rezultate",
	"contact" => "Contact",
	"dashboard" => "Administrare"
);

// conținutul transmis către browser va fi UTF-8
header('Content-Type: text/html; charset=utf-8');

// partea superioară fixă (header) a paginii
require_once "./includes/_header.php"; ?>

<main style="margin-top: 130px; margin-bottom: 50px;">
	<div class="container">
		<?php
		// conținutul efectiv al paginilor
		if (in_array($page, array_keys($pages))) {
			require "$path/$page.php";
		} else {
			require "$path/error.php";
		}
		?>
	</div>
</main>

<?php
// partea inferioară fixă (footer) a paginii
require_once "./includes/_footer.php";
