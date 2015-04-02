<?php 

echo "<ul>";

	foreach ($menu["subj"] as $subj) {
		echo "<li>";
		echo $subj->name;
		foreach ($menu["art"] as $art) {
			if ($art->subject_id == $subj->id) {
				echo "<ul>";
				echo "<li>";
				echo "<a href=/articles/show/" . $art->id .">" . $art->title . "</a>";
				echo "</li>";
				echo "</ul>";
			}
		}
		echo "</li>";
	}

echo "</ul>";

 ?>