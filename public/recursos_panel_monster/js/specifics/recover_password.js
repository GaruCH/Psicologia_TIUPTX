$.validator.addMethod( "emailRegex", function( value, element ) {
	return this.optional( element ) || /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/.test( value );
}, "No corresponde a una ruta de email" );

// FORM RECOVER-PASSWORD VALIDATION
// =================================================================
$("#formulario-recover-password").validate({
    rules:{
        emailrp: {
            required: true,
            emailRegex: true,
            email: true,
            rangelength: [5, 70]
        }
    },//end rules
    messages: {
        emailrp: {
            required: 'Se requiere el correo electrónico del paciente.',
            emailRegex: 'El correo electrónico debe tener el siguiente formato: ejemplo@dominio.com',
            email: 'El correo electrónico debe tener el siguiente formato: ejemplo@dominio.com',
            rangelength: 'El correo electrónico no debe exceder los 70 caracteres.'
        }
    },//end messages
    highlight: function (input) {
        $(input).addClass('is-invalid');
        $(input).removeClass('is-valid');
    },//end highlight
    unhighlight: function (input) {
       $(input).removeClass('is-invalid');
       $(input).addClass('is-valid');
   },//end unhighlight
   errorPlacement: function (error, element) {
       $(element).next().append(error);
   }//end errorPlacement
});//end validation