<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forms</title>

<link href="/Assets/Backend/css/bootstrap.min.css" rel="stylesheet">
<link href="/Assets/Backend/css/datepicker3.css" rel="stylesheet">
<link href="/Assets/Backend/css/styles.css" rel="stylesheet">
<link href="/Assets/Backend/css/sweetalert2.min.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Log in</div>
				<div class="panel-body">
					<form role="form" action="<?= base_url('admin/cek-login-admin');?>" method="post">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Username" name="username" type="text" autofocus="">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" type="password" value="">
							</div>
							<button class="btn btn-primary btn-block" type="submit">Login</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	
		

	<script src="/Assets/Backend/js/jquery-1.11.1.min.js"></script>
	<script src="/Assets/Backend/js/bootstrap.min.js"></script>
	<script src="/Assets/Backend/js/chart.min.js"></script>
	<script src="/Assets/Backend/js/chart-data.js"></script>
	<script src="/Assets/Backend/js/easypiechart.js"></script>
	<script src="/Assets/Backend/js/easypiechart-data.js"></script>
	<script src="/Assets/Backend/js/bootstrap-datepicker.js"></script>
	<script src="/Assets/Backend/js/sweetalert2.min.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>

	<?php if (session()->getFlashdata('success')) : ?>
    	<script type="text/javascript">
    		$(document).ready(function() {
    			swal("Success!", "<?php echo $_SESSION['success'] ?>", "success");
    		});
    	</script>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
    	<script type="text/javascript">
    		$(document).ready(function() {
    			swal("Sorry!", "<?php echo $_SESSION['error'] ?>", "error");
    		});
    	</script>
    <?php endif; ?>
    <?php if (session()->getFlashdata('warning')) : ?>
    	<script type="text/javascript">
    		$(document).ready(function() {
    			swal("Warning!", "<?php echo $_SESSION['warning'] ?>", "warning");
    		});
    	</script>
    <?php endif; ?>
    <?php if (session()->getFlashdata('info')) : ?>
    	<script type="text/javascript">
    		$(document).ready(function() {
    			swal("Info!", "<?php echo $_SESSION['info'] ?>", "info");
    		});
    	</script>
    <?php endif ;?>
</body>

</html>
