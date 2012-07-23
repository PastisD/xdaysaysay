<!-- BEGIN teams_search -->
     <div class="contentLink bloc">
						<p>Lien IRC : <a href="{teams_search.IRC}" title="Lien IRC">{teams_search.NAME}</a></p>
					</div>
 <!-- BEGIN xdccs_search -->
					<div class="botInfo">
						<p class="botName">{teams_search.xdccs_search.NAME}</p>
					</div>
					<table cellspacing="0" class="listing">
						<tr>
							<th>Pack</th>
							<th>Fichier</th>
							<th>Taille</th>
							<th>Downloads</th>
						</tr>
  <!-- BEGIN packs_search -->
						<tr class="{teams_search.xdccs_search.packs_search.CLASS}">
							<td>Pack #{teams_search.xdccs_search.packs_search.ID}</td>
							<td><a href="javascript:link('{teams_search.xdccs_search.NAME}', {teams_search.xdccs_search.packs_search.ID})" title="{teams_search.xdccs_search.packs_search.NAME}">{teams_search.xdccs_search.packs_search.CUT_NAME}</a></td>
							<td>{teams_search.xdccs_search.packs_search.SIZE}</td>
							<td>x{teams_search.xdccs_search.packs_search.GETS}</td>
						</tr>
  <!-- END packs_search -->
					</table>
 <!-- END xdccs_search -->
<!-- END teams_search -->
<!-- BEGIN no_result -->
     <div class="contentLink bloc">
						<p>Aucun r&eacute;sultat trouv&eacute;</p>
 <!-- BEGIN leveinstein -->
						<p>Vouliez-vous dire :  
  <!-- BEGIN words -->
       <a href="{no_result.leveinstein.words.URL}" title="{no_result.leveinstein.words.WORD}">{no_result.leveinstein.words.WORD}</a>
  <!-- END words -->
      </p>
 <!-- END leveinstein -->
					</div>
<!-- END no_result -->
