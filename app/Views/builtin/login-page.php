<!DOCTYPE HTML>
<html lang="en">
<title><?= $site_title ?></title>
<meta name="descrition" content="<?= $site_title ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?= $config->baseURL . 'public/images/favicon.png?r=' . time() ?>" />
<link rel="stylesheet" type="text/css" href="<?= $config->baseURL . 'public/vendors/bootstrap/css/bootstrap.min.css?r=' . time() ?>" />
<link rel="stylesheet" type="text/css" href="<?= $config->baseURL . 'public/vendors/font-awesome/css/all.css?r=' . time() ?>" />
<link rel="stylesheet" type="text/css" href="<?= $config->baseURL . 'public/themes/modern/builtin/css/login.css?r=' . time() ?>" />
<link rel="stylesheet" type="text/css" href="<?= $config->baseURL . 'public/themes/modern/builtin/css/login-header.css?r=' . time() ?>" />

<script type="text/javascript" src="<?= $config->baseURL . 'public/vendors/jquery/jquery-3.4.1.js?r=' . time() ?>"></script>
<script type="text/javascript" src="<?= $config->baseURL . 'public/vendors/bootstrap/js/bootstrap.min.js?r=' . time() ?>"></script>
<?php
if (!empty($js)) {
	foreach ($js as $file) {
		echo '<script type="text/javascript" src="' . $file . '?r=' . time() . '"></script>';
	}
}

?>

</html>

<body>
	<div class="background"></div>
	<div class="backdrop"></div>
	<div class="login-container">
		<div class="login-header">
			<div class="logo">
				<img src="<?php echo $config->baseURL . '/public/images/' . $settingWeb->logo_login ?>">
			</div>

			<?php if (!empty($desc)) {
				echo '<p>' . $desc . '</p>';
			} ?>
		</div>
		<div class="login-body">
			<?php

			if (!empty($message)) { ?>
				<div class="alert alert-danger">
					<?= $message ?>
				</div>
			<?php }
			//echo password_hash('admin', PASSWORD_DEFAULT);
			?>
			<form method="post" action="" class="form-horizontal form-login">
				<div class="form-group input-group">
					<div class="input-group-prepend login-input">
						<span class="input-group-text" id="basic-addon1">
							<i class="fa fa-user"></i>
						</span>
					</div>
					<input type="text" name="username" id="username" value="<?= @$_POST['username'] ?>" class="form-control login-input" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required>
				</div>
				<div class="form-group input-group">
					<div class="input-group-prepend login-input">
						<span class="input-group-text" id="basic-addon1">
							<i class="fa fa-lock" style="font-size:22px"></i>
						</span>
					</div>
					<input type="password" name="password" class="form-control login-input" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
				</div>

				<?php
				// echo $tipeLoginCompSite;
				if ($tipeLoginCompSite) {
				?>
					<div class="form-group input-group">
						<div class="input-group-prepend login-input">
							<span class="input-group-text" id="basic-addon1">
								<i class="fas fa-landmark" style="font-size:22px"></i>
							</span>
						</div>
						<select id="COMPANYID" name="COMPANYID" class="form-control login-input">
							<option value="">Comp ID</option>
						</select>
					</div>

					<div class="form-group input-group">
						<div class="input-group-prepend login-input">
							<span class="input-group-text" id="basic-addon1">
								<i class="fas fa-archway" style="font-size:22px"></i>
							</span>
						</div>
						<select id="COMPANYSITEID" name="COMPANYSITEID" class="form-control login-input">
							<option value="">Site ID</option>
						</select>
					</div>

				<?php
				}
				?>

				<!-- dimatikan eko remember me karena blm tw cara menguji dan membenarkan nya -->
				<!-- 			<div class="form-group input-group">
				<div class="checkbox">
					<label style="font-weight:normal"><input name="remember" value="1" type="checkbox">&nbsp;&nbsp;Remember me</label>
				</div>
			</div> -->
				<div class="form-group" style="margin-bottom:7px">
					<button type="submit" class="form-control btn <?= $settingWeb->btn_login ?>" name="submit">Submit</button>
					<?php
					$form_token = $auth->generateFormToken('login_form_token');
					?>
					<input type="hidden" name="form_token" value="<?= $form_token ?>" />
				</div>
		</div>
		<div class="copyright">
			<?php
			$footer_login = $settingWeb->footer_login ? str_replace('{{YEAR}}', date('Y'), $settingWeb->footer_login) : '';
			echo $footer_login;
			?>
		</div>
	</div><!-- login container -->
</body>

</html>

<script>
	$(document).ready(function() {

		if(<?php echo $tipeLoginCompSite; ?>){
			if ($('#username').val() != '') {
				var username = $('#username').val();
				generateCompany(username);
			}

			$('#username').change(function() {

				var username = $('#username').val();

				// alert(username);
				if (username != '') {
					generateCompany(username);
				} else {
					$('#COMPANYID').val('');
				}
				$('#COMPANYSITEID').val('');
			});
		}

		

		$('#COMPANYID').change(function() {

			var username = $('#username').val();
			var companyid = $('#COMPANYID').val();

			// alert(username);
			if (username != '' && companyid != '') {
				$.ajax({
					url: "<?php echo base_url() . '/login/getCompanySiteID'; ?>",
					method: "POST",
					data: {
						username: username,
						companyid: companyid
					},
					dataType: "JSON",
					success: function(data) {
						var html = '<option value="">Pilih CompSite ID</option>';

						for (var count = 0; count < data.length; count++) {

							html += '<option value="' + data[count].COMPANYSITEID + '">' + data[count].COMPANYSITENAME + '</option>';

						}

						$('#COMPANYSITEID').html(html);
					}
				});
			} else {
				$('#COMPANYSITEID').val('');
			}

		});
	});

	function generateCompany(username) {
		$.ajax({
			url: "<?php echo base_url() . '/login/getCompID'; ?>",
			method: "POST",
			data: {
				username: username
			},
			dataType: "JSON",
			success: function(data) {
				var html = '<option value="">Pilih Comp ID</option>';

				for (var count = 0; count < data.length; count++) {

					html += '<option value="' + data[count].COMPANYID + '">' + data[count].COMPANYNAME + '</option>';

				}

				$('#COMPANYID').html(html);
			}
		});

		// tambahan untuk set required comp site login
		// var roleFree = <?php echo count($roleNoCompSite); ?> ;			
		// if(roleFree > 0){
			generateAttrCompanySite(username);
		// }
	}

	// tambahan untuk set required comp site login
	function generateAttrCompanySite(username) {
		$.ajax({
			url: "<?php echo base_url() . '/login/getAttrCompanySite'; ?>",
			method: "POST",
			data: {
				username: username
			},
			dataType: "JSON",
			success: function(data) {
				// alert(data.requiredStat);

				var compField = document.getElementById("COMPANYID");
    			var compsiteField = document.getElementById("COMPANYSITEID");

				if(data.requiredStat == 'true'){
					compField.setAttribute('required','required');
					compsiteField.setAttribute('required','required');
				} else {
					compField.removeAttribute('required');  
					compsiteField.removeAttribute('required');  
				}
				
			}
		});
	}
</script>