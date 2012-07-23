<script type="text/javascript" src="{$URI}/system/templates/jscripts/intranet/users.js"></script>
<div id="content">
 <div class="red_668_bottom">
  <div class="red_668_top context_menu">
   <script type="text/javascript" src="/jscripts/users.js"></script>
   <h2>{$HEAD}</h2>

   <form name="form" id="form" action="javascript:void(0);" method="post" onsubmit="addEditUser();" class="grey">
    <input type="hidden" name="action_form" value="{$MODE}" />
    <input type="hidden" name="id_user" value="{$ID_USER}" />
    <table class="form">
     <tbody>
      <tr>
       <th><label for="form_username">Login</label></th>
       <td><input type="text" name="username" id="form_username" value="{$USERNAME}" /></td>

      </tr>
      <tr class="sep"><td colspan="2">&nbsp;</td></tr>
      <tr>
       <th><label for="form_password">Mot de passe</label></th>
       <td><input type="password" name="password" id="form_password" value="" /></td>
      </tr>
      <tr>

       <th><label for="form_password2">R&eacute;p&eacute;ter mot de passe</label></th>
       <td><input type="password" name="password_bis" id="form_password_bis" value="" /></td>
      </tr>
      <tr class="sep"><td colspan="2">&nbsp;</td></tr>
      <tr>
       <th><label for="form_password">E-mail</label></th>
       <td><input type="text" name="email" id="form_email" value="{$EMAIL}" /></td>
      </tr>
      <tr class="sep"><td colspan="2">&nbsp;</td></tr>
      <tr>
       <th></th>
       <td><input type="checkbox" name="isadmin" id="form_isadmin" value="1" class="checkbox"{$ISADMIN}/> <label for="form_isadmin" class="nostyle">Est administrateur</label></td>
      </tr>
<!--      <tr class="sep"><td colspan="2">&nbsp;</td></tr>
      <tr>
       <th><label for="form_password">Teams</label></th>
       <td>
        <select id="form_teams" name="teams" multiple="multiple" style="height: 150px;">
         {html_options options=$TEAMS selected=$TEAMSSELECTED}
        </select>
       </td>

      </tr>
-->
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
