<div id="listeUtilisateurs">
    <table class="list red" onselectstart="return false;" onmousedown="if( typeof event.preventDefault != 'undefined' ) event.preventDefault();">
        <thead>
            <tr>
                <th style="width:50px;">
                    <a href="javascript:void(0);" onclick="changeOrder('id_user',this);updateListeUtilisateurs();" class="order_none">Id</a>
                </th>
                <th>
                    <a href="javascript:void(0);" onclick="changeOrder('login',this);updateListeUtilisateurs();" class="order_none">Login</a>
                </th>
                <th>
                    <a href="javascript:void(0);" onclick="changeOrder('email',this);updateListeUtilisateurs();" class="order_none">Email</a>
                </th>
                <th style="width:70px;">
                    <a href="javascript:void(0);" onclick="changeOrder('is_admin',this);updateListeUtilisateurs();" class="order_none">Admin.</a>
                </th>
            </tr>
        </thead>
        <tbody>
            {section name=index loop=$INFOS_USER}
            <tr id="e_{$INFOS_USER[index].id}" class="{if (($smarty.section.index.index % 2 ) == 0 )}l_0{else}l_1{/if} context_menu">
                <td class="id nowrap">
                    <strong>{$INFOS_USER[index].id}</strong>
                </td>
                <td class="nom nowrap">
                    <strong>{$INFOS_USER[index].username}</strong>
                </td>
                <td class="nom nowrap">
                    <strong>{$INFOS_USER[index].email}</strong>
                </td>
                {if $INFOS_USER[index].is_admin == '1'}
                <td class="alert_2"><img src="{$URI}/system/templates/imgs/blank.gif" alt="L'utilisateur est administrateur" title="L'utilisateur est administrateur" /></td>
                {else}
                <td class="alert_0"><img src="{$URI}/system/templates/imgs/blank.gif" alt="L'utilisateur n'est pas administrateur" title="L'utilisateur n'est pas administrateur" /></td>
                {/if}
            </tr>
            {sectionelse}
            <tr>
                <td class="nowrap" colspan="3">
                    <strong>Aucun utilisateur enregistré.</strong>
                </td>
            </tr>
            {/section}

        </tbody>
    </table>
    <h6 id="navPagesUtilisateurs">{$PAGINATION}</h6>
</div>