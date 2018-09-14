$(document).ready(function() {

  console.log('Locked & loaded');

  // Serialize Function
  $.fn.serializeObject = function()
  {
      var o = {};
      var a = this.serializeArray();
      $.each(a, function() {
          if (o[this.name] !== undefined) {
              if (!o[this.name].push) {
                  o[this.name] = [o[this.name]];
              }
              o[this.name].push(this.value || '');
          } else {
              o[this.name] = this.value || '';
          }
      });
      return o;
  };

  // Prevent the form submission defaulting to controller
  $(document).on("click", "#form_submit", function(e){

    // Prevent normal form submission
    e.preventDefault();

    // Disable button
    $('#form_submit').attr("disabled",true);

    var name = $("#form_name").val();
    var email = $("#form_email").val();

    // var data = $('[name="form"]').serializeObject();

    $.ajax({
      url: '/demoformajaxsubmittest',
      type: 'POST',
      dataType: 'json',
      // data: data,
      data: { name : name ,  email : email },
      success:function(response){

      console.log(response);

      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr.responseText);
        console.log(thrownError);
        $('#form_submit').attr("disabled",false);
      }

    });

  });

});
