<script type="text/javascript" src="{$URI}/system/templates/jscripts/intranet/servers.js"></script>
<div id="content">
 <div class="red_668_bottom">
  <div class="red_668_top context_menu">
   <h2>{$HEAD}</h2>

   <form name="form" id="form" action="javascript:void(0);" method="post" onsubmit="addEditServer();" class="grey">
    <input type="hidden" name="action_form" value="{$MODE}" />
    <input type="hidden" name="id" value="{$ID}" />
    <table class="form">
     <tbody>
      <tr>
       <th><label for="form_alias">Alias</label></th>
       <td><input type="text" name="alias" id="form_alias" value="{$ALIAS}" /></td>
      </tr>
      <tr>
       <th><label for="form_host">Hôte</label></th>
       <td><input type="text" name="host" id="form_host" value="{$HOST}" /></td>
      </tr>
      <tr>
       <th><label for="form_http_port">SSL</label></th>
       <td>
        <input type="radio" name="ssl" id="ssl_yes" value="yes"{$SSL_YES} /><label for="ssl_yes">Oui</label>
	 <input type="radio" name="ssl" id="ssl_no" value="no"{$SSL_NO} /><label for="ssl_no">Non</label>
       </td>
      </tr>
      <tr>
       <th><label for="form_http_port">Port HTTP</label></th>
       <td><input type="text" name="http_port" id="form_http_port" value="{$HTTP_PORT}" /></td>
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
