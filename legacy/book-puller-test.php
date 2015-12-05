<html>
	<form>
		Feed meh sum ISBN!!!
		<input type="text" name="key" />
		<br/>
		<input type="submit" />
	</form>
	<?php
		include 'book-puller.php';
		if (isset($_GET["key"])) {
			$keyword = $_GET["key"];
			$theUrl = "http://www.amazon.com/s/keywords=$keyword";
			$searchString = getXML($theUrl);
			$newLink = getSubstring($searchString, "a-link-normal a-text-normal", "<a", "href=\"", "\"");

			$searchString = getXML($newLink);
			$imgLink = getSubstring($searchString, "imgBlkFront", "<img", "src=\"", "\"", "\"");
			$bookTittle = getSubstring($searchString, "productTitle", "<span", ">", "<", ">");
			$author = getSubstring($searchString, "contributorNameID", "<a", ">", "<", ">");
			
			echo "BLEH!<br/><br/>";
			echo "<img src=\"$imgLink\" /><br/>";
			echo "<h1>Title: $bookTittle</h1>";
			echo "<p>Author: $author</p>";
		}
	?>
</html>
