<html>
	<head>
	<link rel="stylesheet" type="text/css" href="stylesheets/generalstylesheet.css">
	<script type="text/javascript" src="jquery1.1.min.js"></script>
		<title>Update Family Doctor</title>
	</head>
	<body> 
		<div id="page-wrap">
			<div id="header">
				<div id="titlebar">
					<h1>Radiology Information System</h1>
				</div>
			</div>
				<div id="content-wrap" class="styleform">
					<h2>Update Family Doctor</h2>
					<h3>*required field</h3>
					<div id="alertbox">
					</div>
					<form id='form1' name="form1" action='usermanagement/php/searchfamilydoctor.php' method="post" class='ajaxform'>
						<label for="email">*Email from doctor:</label><input id="email" name="email" type="text"></br>
						<label for="email2">*Email from patient:</label><input id="email2" name="email2" type="text"></br>
						<input type="submit" name="submit" value="Search family doctor">
					</form></br></br>
					<form id='form2' name="form2" action='usermanagement/php/searchfamilydoctor.php' method="post" class='ajaxform2'>
						<label for="email3">*Email from doctor:</label><input id="email3" name="email3" type="text"></br>
						<label for="email4">*Email from patient:</label><input id="email4" name="email4" type="text"></br>
						<input type="submit" name="submit" value="Search family doctor">
					</form>
				</div>
			<div id="footer">
			</div>
		</div>	
	</body>
	<script>
jQuery(document).ready(function(){
	//Hides form
	$('#form2').hide();

	jQuery('.ajaxform').submit( function() {
		$.ajax({
			url     : $(this).attr('action'),
			type    : $(this).attr('method'),
			data    : $(this).serialize(),
			success : function( data ) {
				//Parses JSON data 
				var data = $.parseJSON(data);
				
				alert(data['message']);
				alert(data['status']);
				
				//Resets input highlights
				$('input').css('border','1px solid #999');

				//Sets parameters for form based on resulting data
				if(data['status'] == true) {
					
					//Change color of text in alert box
					$("#alertbox").css('color','green');

					//Clears input boxes
					$('#email').val('');
					$('#email2').val('');

					//Shows form
					$('#form2').show();

				}
				else {
					//Change color of text in alert box
					$("#alertbox").css('color','red');
					
					//Sets parameters for input boxes
					if(data['message'].indexOf('doctors') >= 0) {
						$('#email').css('border','1px solid red');
						$('#email').val('');
					}
					if(data['message'].indexOf('patients') >= 0) {
						$('#email2').css('border','1px solid red');
						$('#email2').val('');
					}
				}
				//Display message into alert box
				$("#alertbox").html(data["message"]);

			},
			error   : function(){
				alert('Something wrong');
			}
		});
		return false;
	});
});
	
	</script>

</html>
