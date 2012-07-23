<div id="listeServers">
 <table class="list red" onselectstart="return false;" onmousedown="if( typeof event.preventDefault != 'undefined' ) event.preventDefault();">
  <thead>
   <tr>
    <th style="width:50px;">
     <a href="javascript:void(0);" onclick="changeOrder('id',this);updateListeServers();" class="order_none">Id</a>
    </th>
    <th style="width:50px;">
     <a href="javascript:void(0);" onclick="changeOrder('alias',this);updateListeServers();" class="order_none">Alias</a>
    </th>
    <th>
     <a href="javascript:void(0);" onclick="changeOrder('host',this);updateListeServers();" class="order_none">Host</a>
    </th>
   </tr>
  </thead>
  <tbody>
   {section name=index loop=$INFOS_SERVERS}
   <tr id="e_{$INFOS_SERVERS[index].id}" class="{if (($smarty.section.index.index % 2 ) == 0 )}l_0{else}l_1{/if} context_menu">
    <td class="id nowrap">
     <strong>{$INFOS_SERVERS[index].id}</strong>
    </td>
    <td class="nowrap">
     <strong>{$INFOS_SERVERS[index].alias}</strong>
    </td>
    <td class="nom nowrap">
     <strong>{$INFOS_SERVERS[index].host}</strong>
    </td>
   </tr>
   {sectionelse}
   <tr>
    <td class="nowrap" colspan="3">
     <strong>Aucune serveur enregistré.</strong>
    </td>
   </tr>
   {/section}
  </tbody>
 </table>
 <h6 id="navPagesServers">{$PAGINATION}</h6>
</div>