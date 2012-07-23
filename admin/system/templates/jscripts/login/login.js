function goLogin( )
{

    var data = $('#f_connexion :input').serializeArray();
    $('#f_connexion :input[type=submit]').attr( 'disabled', 'disabled' );

    var logged = false;
    var url = URI + '/system/ajax/login/login.php'

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: 'json',
        success: function(data){
            if( data.status == true ) {
                switch(data.redirect) {
                    case 'teams':
                        window.location = URI + '/teams/';
                        break;
                    case 'xdccs':
                        window.location = URI + '/xdccs/';
                        break;
                    case 'servers':
                        window.location = URI + '/servers/';
                        break;
                    case 'users':
                        window.location = URI + '/users/';
                        break;
                    default:
                        window.location = URI + '/';
                }

                logged = true;
            } else if( data.status == false || data.status == "" ) {
                errorLogin(4);
                logged = false;
            } else {
                errorLogin(1);
                logged = false;
            }
        }
    });

/*
    $.post( url,
        data,
        function (data)
        {
            if( data.status == true ) {
                switch(data.redirect) {
                    case 'teams':
                        window.location = URI + '/teams/';
                        break;
                    case 'xdccs':
                        window.location = URI + '/xdccs/';
                        break;
                    case 'servers':
                        window.location = URI + '/servers/';
                        break;
                    case 'admin':
                        window.location = URI + '/admin/';
                        break;
                    default:
                        window.location = URI + '/';
                }

                logged = true;
            } else if( data.status == false || data.status == "" ) {
                errorLogin(4);
                logged = false;
            } else {
                errorLogin(1);
                logged = false;
            }
        }, 'json');
*/
    if( logged === false ){
        $('#f_connexion :input[type=submit]').removeAttr( 'disabled' );
    }

}



/* Show error description for an login error */

function errorLogin( idError )
{
    switch( idError )
    {
        case 1: alert( "Une erreur est survenue, merci de r&eacute;&eacute;ssayer plus tard ou contactez le webmaster.", "Connexion" ); break;
        case 2: alert( "Vous &ecirc;tes maintenant d&eacute;connect&eacute; de votre espace membre.<br />\nVous pouvez vous reconnecter &agrave; tout moment en remplissant le formulaire de connexion.", "D&eacute;connexion" ); break;
        case 4: alert( "Le nom d'utilisateur et/ou le mot de passe que vous avez saisie est invalide.<br />\nSi vous avez oubli&eacute; votre mot de passe, merci de contacter un administrateur.", "Connexion" ); break;
        case 5: alert( "Merci de saisir un nom d'utilisateur (votre adresse email) et un mot de passe valide.", "Connexion" ); break;
    }
}


