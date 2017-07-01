<?php

require_once(CLASSES_PATH ."/sql.php");
require_once(CLASSES_PATH ."/user.php");

class entry
{
	protected $author;
	protected $content;
	protected $id;

	public function getAuthor()
	{
		return $this->author;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getId()
	{
		return $this->id;
	}

	public function __construct($author, $content, $id=null)
	{
		if($id != null) {
			$this->id = $id;
		}
		$this->author = $author;
		$this->content = $content;
	}

	public static function getEntries(user $user)
	{
		
	}

	// Da ist 1 Wurm drin
	public function createNewEntry()
	{
		echo "in der cne funktion";
		if($this->getId() == null) {
			echo "in der if abfrage";
			$sql = "INSERT INTO entry (content, autor) VALUES (:content, :autor)";
			$params = array(':content' => $this->getContent(), ':autor' => $this->getAuthor());
			echo "nach initialisierung der parameter";
			printf($params);
			$sql::exe($sql, $params);
			echo "nach sql query";
		} else {
			?>
			<p>Der Eintrag existiert bereits.</p>
			<?php
		}
	}
	
	public function renderEntry()
	{
		$sql = "SELECT * FROM entry WHERE id = :id";
		$params = array(":id" => $this->id);
		$result = sql::exe($sql, $params);
		?>
		<div class="entry">
			<p>
				<i><?= $result[0]['zeit']?></i>
			</p>
			<p>
				<a href="?page=profile&owner=<?= $result[0]['autor']?>"><b><?= $result[0]['autor']?></b></a>
			</p>
			<p>
				<?= $result[0]['content']?>
			</p>
		</div>
		<?php
	}
}

?>
