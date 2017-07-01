<div id="newEntry">
<h3>Neuer Post</h3>
<form action="index2.php" method="post">
	<textarea name="content"></textarea>
	<button type="submit">Posten</button>
</form>

</div>

<?php

require_once(CLASSES_PATH ."/sql.php");
require_once(CLASSES_PATH ."/user.php");
require_once(CLASSES_PATH ."/entry.php");

if(array_key_exists('content', $_POST)) {
	$username = user::findUserBySid(session_id());
	$entry = new entry($username, $_POST['content']);
	echo "entry objekt wurde erfolgreich erstellt";
	$entry->createNewEntry();
}

?>