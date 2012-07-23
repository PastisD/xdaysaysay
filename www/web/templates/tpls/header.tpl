<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>xdaysaysay - Otaku-IRC.fr</title>
		<link rel="stylesheet" type="text/css" href="{URL}templates/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="{URL}templates/css/xdaysaysay.css" />
		<script type="text/javascript" src="{URL}templates/js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="{URL}templates/js/xdaysaysay.js"></script>
	</head>
	<body>
		<div id="header">
			<div id="headerContent">
				<p>{DATE}</p>
			</div>
		</div>
		<div id="main">
			<a href="{URL}" id="home"></a>
			<div id="topLogo">
				<p class="topBlue">Vous voulez un xdcc ?</p>
				<p class="link">Venez nous en demander un sur <a href="irc://irc.otaku-irc.fr/xdaysaysay">#xdaysaysay</a></p>
			</div>
			<div id="mainTop" class="clearfix">
				<div id="search" class="bloc">
					<h1>Rechercher un fichier</h1>
					<form action="{URL}search/">
      <select name="id_team">
       <option value="">Toutes les teams</option>
       <!-- BEGIN teams -->
       <option value="{teams.ID}"{teams.SELECTED}>{teams.NAME}</option>
       <!-- END teams -->
      </select>
						<input type="text" id="searchBot" name="pattern" value="{SEARCH}" />
						<input type="submit" id="searchSubmit" value="Rechercher" />
					</form>
					<div id="searchInfos">
						<p>Vous pouvez rechercher un fichier en indiquant la team et le nom du fichier.</p>
					</div>
				</div>
				<div id="dons" class="bloc">
     <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
      <input type="hidden" name="cmd" value="_s-xclick" />
      <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHLwYJKoZIhvcNAQcEoIIHIDCCBxwCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYC1Vd2M5/OxPdCcsHCBTkqP6gutVlhpSEeR+nnYID5TxEd/AwoYhKnfeusav4tWCPfy4fsPXCdBeodl9AU3uUnDW0yazZoQ9jnT5JH49Mj1j+jum/DTwHNvGp5LaUE/7tjkqzhlSGRB98FqDXkJg+u5rHG4MwcFdTQLCrk6eGHGyTELMAkGBSsOAwIaBQAwgawGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIEq6l6Ydie5eAgYidkvAXPMFAPJnZtlkxT0lQphNR1ST4ZrGR2G1jIjHHiF2VbfcKwi8a0X/6lUSMZQ8Dpm0/FdtdIh5FayOXG4+nmw2b+NO8PVElVG0ezSkwKewJGyRNgWyxYS5xvyROpaI1KCKp0QGa9ykjvr2IELgJklpMZXd1yAD7KtUb0uSfByEP67rPYxOEoIIDhzCCA4MwggLsoAMCAQICAQAwDQYJKoZIhvcNAQEFBQAwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tMB4XDTA0MDIxMzEwMTMxNVoXDTM1MDIxMzEwMTMxNVowgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDBR07d/ETMS1ycjtkpkvjXZe9k+6CieLuLsPumsJ7QC1odNz3sJiCbs2wC0nLE0uLGaEtXynIgRqIddYCHx88pb5HTXv4SZeuv0Rqq4+axW9PLAAATU8w04qqjaSXgbGLP3NmohqM6bV9kZZwZLR/klDaQGo1u9uDb9lr4Yn+rBQIDAQABo4HuMIHrMB0GA1UdDgQWBBSWn3y7xm8XvVk/UtcKG+wQ1mSUazCBuwYDVR0jBIGzMIGwgBSWn3y7xm8XvVk/UtcKG+wQ1mSUa6GBlKSBkTCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb22CAQAwDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQUFAAOBgQCBXzpWmoBa5e9fo6ujionW1hUhPkOBakTr3YCDjbYfvJEiv/2P+IobhOGJr85+XHhN0v4gUkEDI8r2/rNk1m0GA8HKddvTjyGw/XqXa+LSTlDYkqI8OwR8GEYj4efEtcRpRYBxV8KxAW93YDWzFGvruKnnLbDAF6VR5w/cCMn5hzGCAZowggGWAgEBMIGUMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbQIBADAJBgUrDgMCGgUAoF0wGAYJKoZIhvcNAQkDMQsGCSqGSIb3DQEHATAcBgkqhkiG9w0BCQUxDxcNMDgxMDEzMjExNDA0WjAjBgkqhkiG9w0BCQQxFgQUjPXbCHO4XdQ9DfuAPyvl/Q7+l58wDQYJKoZIhvcNAQEBBQAEgYCG5g+E6zX1yfvu06p/d0aGLsMVRvsTbuV+KJQWqQDkzeJZ2MdvbsE/CBI8JhbESKfubFdD5d5MTtsntNwNt9N2rlSv52wcQLrlKmb/R1xpIpORASm0b0Hz0kS66jBEHHpVMtlkbimqerGgBsoUbx0T16JuxtKoQvsPxEEykgYNNg==-----END PKCS7-----  " />
      <input value="Faire un don" id="sendDon" type="submit" name="submit" alt="" />
      <a id="cards"></a>
     </form>
				</div>
			</div>
			<div id="mainContent">
				<div id="menu" class="bloc">
					<h2>Parcourir les XDCC</h2>
					<ul>
      <!-- BEGIN teams -->
						<li class="menuStep">
							<a href="#" class="team">{teams.NAME}</a>
							<ul>
        <!-- BEGIN xdccs -->
								<li class="bot"><a class="{teams.xdccs.SELECTED}" href="{URL}xdcc/{teams.URI_NAME},{teams.ID}/{teams.xdccs.URI_NAME},{teams.xdccs.ID}/">{teams.xdccs.NAME}</a></li>
        <!-- END xdccs -->
							</ul>
						</li>
      <!-- END teams -->
					</ul>
				</div>
				<div id="content">