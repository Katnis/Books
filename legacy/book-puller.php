<?php
	//Method to pull plain XML text
	function getXML($url) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$plainXML = curl_exec($curl);
		curl_close($curl);
		return $plainXML;
	}
	
	/* Method to extract desired strings out.
	 * Principle:
	 * 		Example: 
	 *			- We have a string: "some text before the element we need <a href="this is what we need" id="theIdentifier">"
	 * 			- First we search of the identifier.
	 * 			- Then from the identifier we search backward to find the element name (anchor point. In this case is "<a")
	 * 			- Then we search for the starting point (after href=")
	 * 			- And the ending point which is the " sign.
	 */
	function getSubstring($theString, $identifier, $anchorPoint, $stringStart, $stringEnd, $checkOff = null) {
		$startingPos = mb_strpos ($theString, $identifier);
		if (!isset($startingPos)) return false;
		$anchorLoc = strrpos (substr($theString, 0, $startingPos), $anchorPoint);
		$startLoc = mb_strpos ($theString, $stringStart, $anchorLoc) + strlen($stringStart);
		$endLoc = mb_strpos ($theString, $stringEnd, $startLoc);
		$result = substr($theString, $startLoc, $endLoc - $startLoc);
		if (isset($checkOff)) {
			$offSet = mb_strpos ($result, $checkOff, 0);
			if ($offSet !== false) {
				$result = substr($theString, $startLoc + $offSet + 1, $endLoc - $startLoc);
			}
		}
		return $result;
	}
	function getData($searchString) {
		$newLink = getSubstring($searchString, "a-link-normal a-text-normal", "<a", "href=\"", "\"");
		$searchString = getXML($newLink);
		$imgLink = getSubstring($searchString, "imgBlkFront", "<img", "src=\"", "\"", "\"");
		$price = getSubstring($searchString, "offer-price", "<span", ">", "<", ">");
		return array($imgLink, $price);
	}
?>