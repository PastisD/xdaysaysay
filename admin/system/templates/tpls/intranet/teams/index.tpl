<script type="text/javascript" src="{$URI}/system/templates/jscripts/intranet/teams.js"></script>
    <div id="content">
        <div class="contextMenu" id="menu_contextuel" style="display: none;">
            <ul>
                <li id="context_menu_edit">Modifier la team</li>
                <li id="context_menu_del">Supprimer la team</li>
                <li class="separator"></li>
                <li id="context_menu_refresh">Rafra&icirc;chir la liste des teams</li>
                <li id="context_menu_add">Ajouter une nouvelle team</li>
            </ul>
        </div>

        <div class="red_668_bottom">
            <div class="red_668_top context_menu">
                <h2>
                    <span class="nbTotal"><span>{$TOTAL_TEAMS}</span> team(s)</span>
                    Liste des teams
                    <span id="search_text"></span>
                </h2>
                <p>
                    <em>Pour ajouter une team, faites un clic droit dans le tableau.</em><br />
                    <em>Pour &eacute;diter ou supprimer une team, faites un clic droit sur celui-ci.</em>

                </p>
                {$LIST_TEAMS}
            </div>
        </div>
    </div>
    <div id="search" class="red_216_bottom">
        <div class="red_216_top">
            <h2>Recherche</h2>

            <form name="search" action="javascript:void(0);" method="get" onsubmit="searchTeam(this.w.value);">
                <input type="text" name="w" value="" class="text" />
                <input type="button" name="close" value="" onclick="stopSearchTeam();" class="close" />
                <input type="submit" name="valider" value="Rechercher..." class="submit" />
            </form>
        </div>
    </div>




