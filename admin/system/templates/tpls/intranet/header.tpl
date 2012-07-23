<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
    <head>
        <title>Listing XDCC | Intranet</title>

        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="" />
        <meta name="robots" content="noindex, nofollow" />

        <style type="text/css" media="screen">
            @import url( '{$URI}/system/templates/css/main.css' );
            @import url( '{$URI}/system/templates/css/forms.css' );
        </style>

        <!--[if IE]>
        <style type="text/css" media="screen">
         @import url( '/css/correction_ie.css' );
        </style>
        <![endif]-->

        <script type="text/javascript" src="{$URI}/system/templates/jscripts/jquery/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="{$URI}/system/templates/jscripts/jquery/jquery.corner.js"></script>
        <script type="text/javascript" src="{$URI}/system/templates/jscripts/jquery/jquery-impromptu.1.5.js"></script>
        <script type="text/javascript" src="{$URI}/system/templates/jscripts/jquery/jquery.contextmenu.r2.js"></script>
        <script type="text/javascript" src="{$URI}/system/templates/jscripts/intranet/main.js"></script>

        <script type="text/javascript">
            var URI = "{$URI}";
            {literal}
            <!--
            $.SetImpromptuDefaults({
                prefix: "window",
                overlayspeed: "fast",
                promptspeed: "fast",
                opacity: 0.75,
                show: 'fadeIn'
            });
            window.alert = function( message, options )
            {
                if( options != undefined && options != "" )
                    $.prompt( message, options ).children('.window').corner();
                else
                    $.prompt( message ).children('.window').corner();
            };
            //-->
            {/literal}
        </script>

    </head>

    <body>
        <!-- HEADER - START //-->
        <div id="header_full">
            <div id="header">
                <a href="{$URI}" title="" id="header_logo"></a>
                <div id="header_sub"></div>

                <ul id="menu_header">

                    <li><a href="{$URI}/"{$INDEX_SELECTED}>Accueil</a></li>

                    <li><a href="{$URI}/xdccs/"{$XDCCS_SELECTED}>Xdccs</a></li>
                    <li class="deco"><a href="{$URI}/?logout">Se d&eacute;connecter</a></li>
                    <!-- BEGIN is_admin -->
                    <li class="admin"><a href="{$URI}/ircservers/"{$IRC_SERVERS_SELECTED}>Serveurs IRC</a></li>
                    <li class="admin"><a href="{$URI}/servers/"{$SERVERS_SELECTED}>Serveurs</a></li>
                    <li class="admin"><a href="{$URI}/teams/"{$TEAMS_SELECTED}>Teams</a></li>
                    <li class="admin"><a href="{$URI}/users/"{$USERS_SELECTED}>Utilisateurs</a></li>
                    <!-- END is_admin -->
                </ul>
            </div>
        </div>
        <!-- HEADER - END //-->

        <div id="middle">
            <div id="menu" class="grey_216_bottom">
                <div class="grey_216_top notitle">
                    <ul>
                        <li><a href="{$URI}/"{$INDEX_SELECTED}>Accueil</a></li>
                    </ul>
                    <ul>
                        <li><a href="{$URI}/xdccs/"{$XDCCS_SELECTED}>Xdccs</a></li>
                    </ul>
                    <!-- BEGIN is_admin -->
                    <ul>
                        <li><a href="{$URI}/ircservers/"{$IRC_SERVERS_SELECTED}>Serveurs IRC</a></li>
                        <li><a href="{$URI}/servers/"{$SERVERS_SELECTED}>Serveurs</a></li>
                        <li><a href="{$URI}/teams/"{$TEAMS_SELECTED}>Teams</a></li>
                        <li><a href="{$URI}/users/"{$USERS_SELECTED}>Utilisateurs</a></li>
                    </ul>
                    <!-- END is_admin -->
                </div>
            </div>
