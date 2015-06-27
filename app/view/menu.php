<?php 

echo "<ul>";

	foreach ($menu["subj"] as $subj) {
		echo "<li>";
		echo "<a href=''>" . $subj->name . "</a>";
		echo "</li>";
	}

echo "</ul>";

 ?>