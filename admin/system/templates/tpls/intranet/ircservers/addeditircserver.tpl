<script type="text/javascript" src="{$URI}/system/templates/jscripts/intranet/ircservers.js"></script>
<div id="content">
    <div class="red_668_bottom">
        <div class="red_668_top context_menu">
            <h2>{$HEAD}</h2>

            <form name="form" id="form" action="javascript:void(0);" method="post" onsubmit="addEditIrcServer();" class="grey">
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
                            <th><label for="form_host">Serveur</label></th>
                            <td><input type="text" name="host" id="form_host" value="{$HOST}" /></td>
                        </tr
                        <tr class="sep"><td colspan="2">&nbsp;</td></tr>
                        <tr>

                            <th><label for="form_port">Port</label></th>
                            <td><input type="text" name="port" id="form_port" value="{$PORT}" /></td>
                        </tr>
                        <tr>
                            <th><label for="form_irc_chan">Port SSL</label></th>
                            <td><input type="text" name="port_ssl" id="form_port_ssl" value="{$PORT_SSL}" /></td>
                        </tr>
                        <tr class="sep"><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <th><label for="form_website">Site Web</label></th>
                            <td><input type="text" name="website" id="form_website" value="{$WEBSITE}" /></td>
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
