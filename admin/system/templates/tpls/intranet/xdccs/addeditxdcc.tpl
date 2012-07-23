<script type="text/javascript" src="{$URI}/system/templates/jscripts/intranet/xdccs.js"></script>
<div id="content">
 <div class="red_668_bottom">
  <div class="red_668_top context_menu">
   <h2>{$HEAD}</h2>

   <form name="form" id="form" action="javascript:void(0);" method="post" onsubmit="addEditXdcc();" class="grey">
    <input type="hidden" name="action_form" value="{$MODE}" />
    <input type="hidden" name="id" value="{$ID}" />
    <table class="form">
     <tbody>
<!--      <tr>
       <th>Nom</th>
       <td>{$NAME}</td>
      </tr>-->
      <tr>
       <th><label for="form_server">Serveur</label></th>
       <td>
        <select id="form_server" name="id_server">
         {html_options options=$SERVERS selected=$SERVERSSELECTED}
        </select>
       </td>

      </tr>
      <tr class="sep"><td colspan="2">&nbsp;</td></tr>
      <tr>
       <th><label for="form_url">Url</label></th>
       <td><input type="text" name="url" id="form_url" value="{$URL}" /></td>
      </tr>
      <tr>
       <th></th>
       <td><input type="checkbox" name="show_on_listing" id="form_show_on_listing" value="1" class="checkbox"{$SHOW_ON_LISTING}/> <label for="form_show_on_listing" class="nostyle">Visible sur le listing</label></td>
      </tr>
      <tr class="sep"><td colspan="2">&nbsp;</td></tr>
      <tr>
       <th><label for="form_teams">Teams</label></th>
       <td>
        <select id="form_teams" name="teams" multiple="multiple" style="height: 150px;">
         {html_options options=$TEAMS selected=$TEAMSSELECTED}
        </select>
       </td>

      </tr>
      <tr class="sep"><td colspan="2">&nbsp;</td></tr>
      <tr class="submit">
       <td colspan="2">
        <input type="submit" name="submit" value="Valider" />
        <input type="reset" name="restaurer" value="Restaurer" />
       </td>
      </tr>
     </tbody>
    </table>
   </form>
  </div>
 </div>
</div>
