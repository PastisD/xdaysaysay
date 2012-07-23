<div id="listeIrcServers">
 <table class="list red" onselectstart="return false;" onmousedown="if( typeof event.preventDefault != 'undefined' ) event.preventDefault();">
  <thead>
   <tr>
    <th style="width:50px;">
     <a href="javascript:void(0);" onclick="changeOrder('id',this);updateListeIrcServers();" class="order_none">Id</a>
    </th>
    <th>
     <a href="javascript:void(0);" onclick="changeOrder('name',this);updateListeIrcServers();" class="order_none">Nom</a>
    </th>
    <th>
     <a href="javascript:void(0);" onclick="changeOrder('host',this);updateListeIrcServers();" class="order_none">Serveur</a>
    </th>
    <th>
     <a href="javascript:void(0);" onclick="changeOrder('port',this);updateListeIrcServers();" class="order_none">Port</a>
    </th>
    <th style="width:70px;">
     <a href="javascript:void(0);" onclick="changeOrder('port_ssl',this);updateListeIrcServers();" class="order_none">Port SSL</a>
    </th>
    <th style="width:70px;">
     <a href="javascript:void(0);" onclick="changeOrder('website',this);updateListeIrcServers();" class="order_none">Site Web</a>
    </th>
   </tr>
  </thead>
  <tbody>
   {section name=index loop=$INFOS_IRC_SERVER}
   <tr id="e_{$INFOS_IRC_SERVER[index].id}" class="{if (($smarty.section.index.index % 2 ) == 0 )}l_0{else}l_1{/if} context_menu">
    <td class="id nowrap">
     <strong>{$INFOS_IRC_SERVER[index].id}</strong>
    </td>
    <td class="nom nowrap">
     <strong>{$INFOS_IRC_SERVER[index].name}</strong>
    </td>
    <td class="nom nowrap">
     <strong>{$INFOS_IRC_SERVER[index].host}</strong>
    </td>
    <td class="nom nowrap">
     <strong>{$INFOS_IRC_SERVER[index].port}</strong>
    </td>
    <td class="nom nowrap">
     <strong>{$INFOS_IRC_SERVER[index].port_ssl}</strong>
    </td>
    <td class="nom nowrap">
     <strong>{$INFOS_IRC_SERVER[index].website}</strong>
    </td>
   </tr>
   {sectionelse}
   <tr>
    <td class="nowrap" colspan="5">
     <strong>Aucun serveur IRC enregistré.</strong>
    </td>
   </tr>
   {/section}

  </tbody>
 </table>
 <h6 id="navPagesIrcServers">{$PAGINATION}</h6>
</div>