<div id="listeXdccs">
 <table class="list red" onselectstart="return false;" onmousedown="if( typeof event.preventDefault != 'undefined' ) event.preventDefault();">
  <thead>
   <tr>
    <th style="width:50px;">
     <a href="javascript:void(0);" onclick="changeOrder('id',this);updateListeXdccs();" class="order_none">Id</a>
    </th>
    <th>
     <a href="javascript:void(0);" onclick="changeOrder('team',this);updateListeXdccs();" class="order_none">Team</a>
    </th>
    <th style="width:50px;">
     <a href="javascript:void(0);" onclick="changeOrder('xdcc',this);updateListeXdccs();" class="order_none">Nom</a>
    </th>
    <th>
     <a href="javascript:void(0);" onclick="changeOrder('nb_pack',this);updateListeXdccs();" class="order_none">Packs</a>
    </th>
   </tr>
  </thead>
  <tbody>
   {section name=index loop=$INFOS_XDCCS}
   <tr id="e_{$INFOS_XDCCS[index].id}" class="{if (($smarty.section.index.index % 2 ) == 0 )}l_0{else}l_1{/if} context_menu">
    <td class="id nowrap">
     <strong>{$INFOS_XDCCS[index].id}</strong>
    </td>
    <td class="nom nowrap">
     <strong>{$INFOS_XDCCS[index].team_name}</strong>
    </td>
    <td class="nom nowrap">
     <strong>{$INFOS_XDCCS[index].name}</strong>
    </td>
    <td>
     <strong>{$INFOS_XDCCS[index].nb_pack}</strong>
    </td>
   </tr>
   {sectionelse}
   <tr>
    <td class="nowrap" colspan="3">
     <strong>Aucune xdcc enregistré.</strong>
    </td>
   </tr>
   {/section}
  </tbody>
 </table>
 <h6 id="navPagesXdccs">{$PAGINATION}</h6>
</div>