<!-- BEGIN team -->
     <div class="contentLink bloc">
						<p>Lien IRC : <a href="{team.IRC}" title="Lien IRC">{team.NAME}</a></p>
					</div>
<!-- END team -->
<!-- BEGIN xdcc -->
					<div class="botInfo">
						<p class="botName">{xdcc.NAME}</p>
						<p>{xdcc.PACK_SUM} packs, total des packs: {xdcc.DISK_SPACE}, total transf&eacute;r&eacute;: {xdcc.TRANSFERED_TOTAL}.</p>
						<p>Derni&egrave;re mise &agrave; jour : {xdcc.LAST_UPDATE}.</p>
					</div>
<!-- END xdcc -->
					<table cellspacing="0" class="listing">
						<tr>
							<th>Pack</th>
							<th>Fichier</th>
							<th>Taille</th>
							<th>Downloads</th>
						</tr>
<!-- BEGIN packs -->
						<tr class="{packs.CLASS}">
							<td>Pack #{packs.ID}</td>
							<td><a href="javascript:link('{packs.NAME_XDCC}', {packs.ID})" title="{packs.NAME}">{packs.CUT_NAME}</a></td>
							<td>{packs.SIZE}</td>
							<td>x{packs.GETS}</td>
						</tr>
<!-- END packs -->
					</table>