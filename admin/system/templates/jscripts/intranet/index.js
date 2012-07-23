function autoRedirect(redirect) {

    var data = ({ redirect: redirect });

    $.post( URI + "/system/ajax/intranet/index.php",
        data,
        function (data)
        {
            if( data.status == false ) {
                errorLogin(1)
            } else {
                alert('Vous serez automatiquement redirigez vers la page que vous venez de sélectionner lors de voter prochaine connexion.');
                logged = false;
            }
        }, "json");
}