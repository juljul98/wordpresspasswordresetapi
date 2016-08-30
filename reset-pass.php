<?php

	/*
		Template Name: Password Reset
	*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri().'/';?>js/jquery-1.12.3.min.js"></script>
	<script>
		var ajax_url = "<?php echo site_url(); ?>/ajax";
	</script>
</head>
<body>
	<form action="" method="post" id="resetForm">
		<input type="text" name="email" id="resetpass" placeholder="email">
		<button type="submit" name="resetpass" id="resetpass">reset</button>
	</form>	
	<p class="confirmUrl"></p>
	<script type="text/javascript">
		$('#resetForm').submit(function(e){
			e.preventDefault();
			var data = {};
			data['email'] = $('#resetpass').val();
			reset_pass(data);
		});

		function reset_pass(data) {
			 $.post(ajax_url, {action: 'reset_pass', post_data: data}, function(data){
			 	$('.confirmUrl').text(data.trim().toString());
    	     });

		}
	</script>
</body>
</html>







