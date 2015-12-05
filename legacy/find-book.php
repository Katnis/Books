<?php
include 'book-puller.php';
$isbn= $_GET['isbn'];
$url = 'http://isbndb.com/api/books.xml?access_key=JS90JDQW&results=details&index1=isbn&value1='.$isbn;
$response = simplexml_load_file($url);
if($response->BookList['total_results']>0){
  $theUrl = "http://www.amazon.com/s/keywords=$isbn";
  $searchString = getXML($theUrl);
  $data = getData($searchString);
  $img = $data[0];
  $price = $data[1];
  echo "<img src=\"$img\" /><br/>";
  echo "Price: $price<br/>";
  foreach ($response->BookList->BookData as $book) {
    echo "Title: {$book->Title}<br/>
    Author(s): {$book->AuthorsText}<br/>
    Publisher: {$book->PublisherText}<br/>
    ISBN10: {$book['isbn']}<br/>
    ISBN13: {$book['isbn13']}<br/>
    Edition: {$book->Detials['edition_info']}<br/>
    Language: {$book->Details['language']}<br/>
    Physical Description: {$book->Details['physical_description_text']}
    ";
  }
}else{
  echo "Error";
}
 ?>
