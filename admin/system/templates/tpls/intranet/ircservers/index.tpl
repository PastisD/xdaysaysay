<script type="text/javascript" src="{$URI}/system/templates/jscripts/intranet/ircservers.js"></script>
    <div id="content">
        <div class="contextMenu" id="menu_contextuel" style="display: none;">
            <ul>
                <li id="context_menu_edit">Modifier le serveur IRC</li>
                <li id="context_menu_del">Supprimer le serveur IRC</li>
                <li class="separator"></li>
                <li id="context_menu_refresh">Rafra&icirc;chir la liste des serveurs IRC</li>
                <li id="context_menu_add">Ajouter un nouveau serveur IRC</li>
            </ul>
        </div>

        <div class="red_668_bottom">
            <div class="red_668_top context_menu">
                <h2>
                    <span class="nbTotal"><span>{$TOTAL_IRC_SERVERS}</span> serveur(s) IRC</span>
                    Liste des serveurs IRC
                    <span id="search_text"></span>
                </h2>
                <p>
                    <em>Pour ajouter un serveur IRC, faites un clic droit dans le tableau.</em><br />
                    <em>Pour &eacute;diter ou supprimer un serveur IRC, faites un clic droit sur celui-ci.</em>

                </p>
                {$LIST_IRC_SERVERS}
            </div>
        </div>
    </div>
    <div id="search" class="red_216_bottom">
        <div class="red_216_top">
            <h2>Recherche</h2>

            <form name="search" action="javascript:void(0);" method="get" onsubmit="searchIrcServer(this.w.value);">
                <input type="text" name="w" value="" class="text" />
                <input type="button" name="close" value="" onclick="stopSearchIrcServer();" class="close" />
                <input type="submit" name="valider" value="Rechercher..." class="submit" />
            </form>
        </div>
    </div>




