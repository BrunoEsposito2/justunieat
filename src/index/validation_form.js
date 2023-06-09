function validateEmail(email) 
{
  var regex = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
  return regex.test(email);
}


$(document).ready(function(){
    $("form button").click(function(){

		$(".alert-php").hide();
        event.preventDefault();
        errors = "";
        
        var email = document.getElementById("inputEmail");
        var nome = document.getElementById("inputNome");
        var cognome = document.getElementById("inputCognome");
        var cell = document.getElementById("inputCell");
        var pass = document.getElementById("inputPassword");

        if(nome == null || nome.length < 2) {
            errors += "Il Nome è obbligatorio e deve essere almeno 2 caratteri <br/>";
        }

        if(cognome == null || cognome.length < 2){
			errors += "Il Cognome è obbligatorio e deve essere almeno 2 caratteri <br/>";
		}
		
		if(email == null || !validateEmail(email)){
			errors += "L'Email è obbligatoria e deve essere valida<br/>";
		}

        if(cell == null || cell.length < 10){
			errors += "Il Cellulare è obbligatorio e deve essere valido<br/>";
        }
        
        if(pass == null || pass.length < 10){
			errors += "Il Password è obbligatoria e deve essere valida<br/>";
        }


		if(errors.length > 0)
		{
			var nome = $("div.alert-js p").html(errors);
			$("div.alert-js").show();
		}
		else
		{
			$(this).parent().submit();
		}




    })



})
