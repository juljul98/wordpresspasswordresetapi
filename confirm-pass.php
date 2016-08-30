<?php 

	/* 
		Template Name: Confirm Password
	*/
	global $tigger;
	if($_GET['reset'] == 'teacher') {
		$trigger = 'teacher';
	} else {
		$trigger = 'school';
	}


	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$get_enc = explode('email=', $actual_link);
	$email = $get_enc[1];
	
    $decrypted = decryptIt( $email );

	if(isset($_POST['confirm'])) {
			$args = array(
		            'post_type'=> $trigger,
		            'post_status' => 'publish',
		            'meta_query' => array(
		                array(
		                    'key'     => 'user_email',
		                    'value'   => $decrypted,
		                    'compare' => '=',
		                ),
		            )
		       );
	        
	        $query = new WP_query($args);

	        if($query->have_posts() && $decrypted != ""){

	            $query->the_post();
	                
	            $arr = array(
	            );

	            update_post_meta(get_the_ID(), 'user_password', $_POST['password02']);

	            
	            wp_update_post ($arr);

	            echo "true";
	                 
	        } 
	        else{
	            echo "false";
	        }   
	        wp_reset_postdata();
	}
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
	<form action="" method="post">
		<input type="password" name="password01" id="password01" placeholder="New Password">
		<input type="password" name="password02" id="password02" placeholder="Confirm New Password">
		<button type="submit" name="confirm" id="confirm" disabled="disabled">Confirm</button>
	</form>
	<p></p>
	<script>
		$(document).ready(function() {

			$("#password02").keyup(checkPasswordMatch);
		});
		function checkPasswordMatch() {

		    var password = $("#password01").val();
		    var confirmPassword = $("#password02").val();

		    if (password != confirmPassword) {

		        $("p").html("Passwords do not match!");
		    	$('#confirm').attr('disabled', true);
		    }
		    else {
		    	
		        $("p").html("Passwords match.");
		    	$('#confirm').removeAttr('disabled', 'disabled');
		    }
		}
	</script>
</body>
</html>
<?php


function encryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
}

function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}

