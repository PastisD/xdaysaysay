<script type="text/javascript" src="{$URI}/system/templates/jscripts/intranet/teams.js"></script>
<div id="content">
 <div class="red_668_bottom">
  <div class="red_668_top context_menu">
   <h2>{$HEAD}</h2>

   <form name="form" id="form" action="javascript:void(0);" method="post" onsubmit="addEditTeam();" class="grey">
    <input type="hidden" name="action_form" value="{$MODE}" />
    <input type="hidden" name="id" value="{$ID}" />
    <table class="form">
     <tbody>
      <tr>
       <th><label for="form_name">Nom</label></th>
       <td><input type="text" name="name" id="form_name" value="{$NAME}" /></td>

      </tr>
      <tr class="sep"><td colspan="2">&nbsp;</td></tr>
      <tr>
       <th><label for="form_irc_server">Serveur IRC</label></th>
       <td>
        <select id="form_irc_server" name="irc_server">
         {html_options options=$IRC_SERVERS selected=$IRC_SERVERSSELECTED}
        </select>
       </td>
      </tr>
      <tr class="sep"><td colspan="2">&nbsp;</td></tr>
      <tr>
       <th><label for="form_irc_chan">Chan IRC (avec le #)</label></th>
       <td><input type="text" name="irc_chan" id="form_irc_chan" value="{$IRC_CHAN}" /></td>
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
