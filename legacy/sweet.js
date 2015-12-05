$(document).ready(function(){
  $('#logon').on('submit', function(e){
    var status = '<img class="loading" src="ajax-loader.git" alt="Loading..." />';
    $("#ajax").after(status);
  //  var postData = new FormData(this);
    var formURL = $(this).attr("action");
    $.ajax({
      url: formURL,
      data: $(this).serialize(),
      //dataType: 'json',
      type:'POST',
      success:function(data){
        console.log(data);
        swal({
          title: "Redirect Me",
          text: "Please choose an action to navigate",
          confirmButtonText: "Buy"
        });
      },
        error:function(data){
          swal("Oops...", "Something went wrong :(", "error");
        }
    });
    e.preventDefault(); // stop default action
    e.unbind(); // stop multiple form submit
  });
});
