$(document).ready(function(){
  var isbn;
  $("#getBook").click(function(){
    $("#bookInfo").fadeOut("slow");
    isbn=$("#isbn").val(); // get value of isbn
    $("#bookInfo").load("find-book.php",{isbn:isbn},function(){
      $("#bookInfo").fadeIn("slow");
    });
  });
});
