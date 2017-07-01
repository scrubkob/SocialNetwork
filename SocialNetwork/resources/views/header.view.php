<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/default.css">
	<title><?= SITE_NAME?></title>
</head>
<body>

<nav>
	<div class="clearfix">
		<ul class="topmenu">
			<li>
				<a href="index2.php">Startseite</a>
			</li>
			<li>
				<form action="?page=search&" method="get">
					<input type="hidden" name="page" value="<?= $_GET["page"]?>">
					<input name="suche">
					<button>Suchen</button>
				</form>
			</li>
			<?php
			require_once(CLASSES_PATH ."/login.php");

			if(login::isLoggedin(session_id()))
			{
				?>
				<li>
					<a href="#">Profil</a>
				</li>
				<li>
					<a href="#">Nachrichten</a>
				</li>
				<li>
					<a href="#">Freundschaftsanfragen</a>
				</li>
				<li>
					<a href="?page=logout">Logout</a>
				</li>
				<li>
					<?php
					$username = user::findUserBySid(session_id());
					?>
					<p>Hallo, <?= $username?></p>
				</li>
				<?php
			} else {
				?>
				<li>
					<a href="?page=login">Login</a>
				</li>
				<li>
					<a href="#">Registrieren</a>
				</li>
				<?php
			}
			
			?>
			<li>
				<a href="index.php">Zur alten Version</a>
			</li>
		</ul>
	</div>
</nav>

<div id="wrapper">
<main>
