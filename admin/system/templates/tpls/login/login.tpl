<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
    <head>
        <title></title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="L'&Eacute;tude Financi&egrave;re - Le financement gagnant-gagnant" />
        <meta name="keywords" content="financement,assurance,d�fiscalisation,cr�dit,pr�parer retraite,g�rer budget,gagnant-gagnant,�tude financi�re" />
        <meta name="robots" content="all" />

        <style type="text/css" media="screen">
            @import url( '{$URI}/system/templates/css/login.css' );
        </style>
        <script type="text/javascript" src="{$URI}/system/templates/jscripts/jquery/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="{$URI}/system/templates/jscripts/jquery/jquery-impromptu.1.5.js"></script>
        <script type="text/javascript" src="{$URI}/system/templates/jscripts/jquery/jquery.corner.js"></script>
        <script type="text/javascript" src="{$URI}/system/templates/jscripts/login/login.js"></script>
        <script type="text/javascript">
            <!--
            var URI = "{$URI}";
            {literal}
            $.SetImpromptuDefaults({
                overlayspeed: "fast",
                promptspeed: "fast",
                opacity: 0.75,
                show: 'fadeIn'
            });
            window.alert = function( message, options )
            {
                if( options != undefined && options != "" )
                    $.prompt( message, options ).children('.jqi').corner();
                else
                    $.prompt( message ).children('.jqi').corner();
            };

            function posConnexion()
            {
                var temp = $(window).height();
                var posTop = ( $(window).height() - $("#center").height() ) / 2 - 10;
                var posLeft = ( $(window).width() - $("#center").width() ) / 2;

                $("#center").css( "position", "absolute" );
                $("#center").css( "top", posTop );
                $("#center").css( "left", posLeft );
            }

            $(document).ready( function()
            {
                $(window).resize( function(){ posConnexion(); } );
                posConnexion();
            } );
            {/literal}
            //-->
        </script>
    </head>

    <body>
        <div id="center">
            <div id="connexion">
                <h1>Connexion</h1>

                <form id="f_connexion" name="connexion" method="get" action="javascript:void(0);" onsubmit="goLogin();">
                    <table>
                        <tbody>
                            <tr>
                                <th><label for="f_connexion_login">Nom d'utilisateur</label></th>
                                <td><input type="text" id="f_connexion_login" name="login" value="" tabindex="1" /></td>
                                <th rowspan="2" class="button"><input type="submit" id="f_connexion_submit" name="submit" value="" tabindex="3" /></th>
                            </tr>

                            <tr>
                                <th><label for="f_connexion_password">Mot de passe</label></th>
                                <td><input type="password" id="f_connexion_password" name="password" value="" tabindex="2" /></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>

        </div>
        <script type="text/javascript">errorLogin(0);</script>
    </body>

</html>