// Inputs

$('#fancy-inputs input[type="password"]').blur(function(){
    if($(this).val().length > 0){
      $(this).addClass('white');
    } else {
      $(this).removeClass('white');
    }
  });
  
  // Radios
  
  $("#fancy-radio input[type=radio]").click(function() {
    $('label.radio').removeClass('selected');
    var inputID = $(this).attr('id');
    if ($(this).is(':checked')) {
      $('.' + inputID).addClass('selected');
    } else {
      $('.' + inputID).removeClass('selected');
    }
  });