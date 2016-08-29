$(document).ready(function() {
  $('#contact form').on('submit', function(event){
    event.preventDefault();
    var prenom = $('#prenomContact').val();
    var nom = $('#nomContact').val();
    var email = $('#emailContact').val();
    var message = $('#messageContact').val();
    if(prenom === "" || nom === "" || email === "" || message === "") {
      toastr.error("Les champs ne peuvent pas être vides.")
      return false;
    }
    var emailTest = new RegExp('^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$');
    if(!emailTest.test(email)) {
      toastr.error("Email incorrect.");
      return false;
    }
     $.ajax({
       url: $(this).attr('action'), 
       type: $(this).attr('method'),
       data: $(this).serialize(), 
       dataType: 'json',
       success: function() {
	 toastr.success("Demande de contact envoyé.");
       },
       error: function(json) {
	 toastr.error("Erreur lors de l'envoi de la demande de contact.");
	 for(error in json.errors)
	   toastr.warning(error);
       }
     });
  });
});
