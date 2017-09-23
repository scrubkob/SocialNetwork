<?php
// Achtung: dient zur Erstellung neuer entries und comments
?>
<form action="index.php" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="newEntryContent">Neuer Post</label>
		<textarea class="form-control" rows="3" id="newEntryContent" name="content" placeholder="Neuer Post"></textarea>
	</div>
	
	<div class="form-group">
		<label for="newEntryPicture">Bild hinzufügen</label>
		<input id="newEntryPicture" type="file" name="picture">
	</div>
	<button class="btn btn-default" type="submit">Posten</button>
</form>

<?php

require_once(CLASSES_PATH ."/sql.php");
require_once(CLASSES_PATH ."/user.php");
require_once(CLASSES_PATH ."/entry.php");
require_once(CLASSES_PATH ."/comment.php");

$username = user::findUserBySid(session_id());

if(array_key_exists('content', $_POST) && !array_key_exists('entry', $_GET)) {
	$entry = new entry($username, $_POST['content']);
	$entry->createNewEntry();
	$contentId = $entry->getId();
} elseif(array_key_exists('content', $_POST) && array_key_exists('entry', $_GET)) {
	$comment = new comment($username, $_POST['content'], $_GET['entry']);
	$comment->createNewComment();
	//$contentId = $comment->getId();
}

//if(isset($_POST['picture'])) {
	if(isset($_FILES['picture']['name'])) {
		if($_FILES['picture']['name'] != "") {
			$upload_folder = 'img/content/posts/'. $username .'/'; //Das Upload-Verzeichnis
			if(!file_exists($upload_folder)) {
				mkdir($upload_folder);
			}

			$filename = pathinfo($_FILES['picture']['name'], PATHINFO_FILENAME);
			$extension = strtolower(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION));
			 
			 
			//Überprüfung der Dateiendung
			$allowed_extensions = array('png', 'jpg', 'jpeg', 'gif');
			if(!in_array($extension, $allowed_extensions)) {
			 	die("Ungültige Dateiendung. Nur png, jpg, jpeg und gif-Dateien sind erlaubt");
			}
			 
			//Überprüfung der Dateigröße
			$max_size = 500*1024; //500 KB
			if($_FILES['picture']['size'] > $max_size) {
			 	die("Bitte keine Dateien größer 500kb hochladen");
			}
			 
			//Überprüfung dass das Bild keine Fehler enthält
			if(function_exists('exif_imagetype')) { //Die exif_imagetype-Funktion erfordert die exif-Erweiterung auf dem Server
			 	$allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
			 	$detected_type = exif_imagetype($_FILES['picture']['tmp_name']);
			 	if(!in_array($detected_type, $allowed_types)) {
			 		die("Nur der Upload von Bilddateien ist gestattet");
			 	}
			}
			 
			//Pfad zum Upload
			$new_path = $upload_folder.$contentId.'.'.$extension;
			 
			//Neuer Dateiname falls die Datei bereits existiert
			if(file_exists($new_path)) { //Falls Datei existiert, lösche die alte Datei
			 	unlink($new_path);
			}
			 
			//Alles okay, verschiebe Datei an neuen Pfad
			move_uploaded_file($_FILES['picture']['tmp_name'], $new_path);
		}
	}
//}

?>