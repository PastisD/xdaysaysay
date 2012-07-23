<div id="listeTeams">
    <table class="list red" onselectstart="return false;" onmousedown="if( typeof event.preventDefault != 'undefined' ) event.preventDefault();">
        <thead>
            <tr>
                <th style="width:50px;">
                    <a href="javascript:void(0);" onclick="changeOrder('id',this);updateListeTeams();" class="order_none">Id</a>
                </th>
                <th>
                    <a href="javascript:void(0);" onclick="changeOrder('name',this);updateListeTeams();" class="order_none">Nom</a>
                </th>
                <th>
                    <a href="javascript:void(0);" onclick="changeOrder('irc_server',this);updateListeTeams();" class="order_none">Serveur IRC</a>
                </th>
                <th style="width:70px;">
                    <a href="javascript:void(0);" onclick="changeOrder('chan',this);updateListeTeams();" class="order_none">Chan</a>
                </th>
            </tr>
        </thead>
        <tbody>
            {section name=index loop=$INFOS_TEAM}

            <tr id="e_{$INFOS_TEAM[index].id}" class="{if (($smarty.section.index.index % 2 ) == 0 )}l_0{else}l_1{/if} context_menu">
                <td class="id nowrap">
                    <strong>{$INFOS_TEAM[index].id}</strong>
                </td>
                <td class="nom nowrap">
                    <strong>{$INFOS_TEAM[index].name}</strong>
                </td>
                <td class="nom nowrap">
                    <strong>{$INFOS_TEAM[index].irc_name}</strong>
                </td>
                <td class="nom nowrap">
                     <strong>{$INFOS_TEAM[index].chan_name}</strong>
                </td>
            </tr>
            {sectionelse}
            <tr>
                <td class="nowrap" colspan="4">
                    <strong>Aucune team enregistré.</strong>
                </td>
            </tr>
            {/section}

        </tbody>
    </table>
    <h6 id="navPagesTeams">{$PAGINATION}</h6>
</div>