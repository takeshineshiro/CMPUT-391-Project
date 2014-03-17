<html>
	<head>
	<link rel="stylesheet" type="text/css" href="stylesheets/generalstylesheet.css">
	<script type="text/javascript" src="jquery1.1.min.js"></script>
		<title>Update Person</title>
	</head>
	<body> 
		<div id="page-wrap">
			<div id="header">
				<div id="titlebar">
					<h1>Radiology Information System</h1>
				</div>
			</div>
			<div id="content-wrap" class="styleform">
				<h2>Update Person</h2>
				<form id='form1' name="form1" action='usermanagement/php/searchperson.php' method="post" class='ajaxform'>
					<label><u>Find Person</u></label><br/>						
					<label for="email">Email:</label><input id="email" name="email" type="text"></br>					
					<input type="submit" name="submit" value="Find User">
				</form>
				<div id="alertbox">
				</div>
				<br/>
				<form id='form2' name="form2" action='usermanagement/php/updateperson.php' method="post" class='ajaxform2'>
					<label><u>Update Person</u></label><br/>	
					<input id="person_id" name="person_id" visibility="hidden" type="text">
					<input id="email3" name="email3" visibility="hidden" type="text">
					<label for="firstname2">First Name</label><input id="firstname2" name="firstname2" type="text"></br>
					<label for="lastname2">Last Name:</label><input id="lastname2" name="lastname2" type="text"></br>
					<label for="email2">Email:</label><input id="email2" name="email2" type="text"></br>
					<label for="password2">Address:</label><input id="address2" name="address2" type="text"></br>
					<label for="phone2">Phone:</label><input id="phone2" name="phone2" type="text"></br>
					
					<input type="submit" name="submit" value="Update User">
				</form>
				<div id="alertbox2">
				</div>
			</div>
			<div id="footer">
			</div>
		</div>
			
	</body>
	<script>
jQuery(document).ready(function(){
	//Hides form
	$('#form2').hide();

	//Hides input that stores person_id
	$('#person_id').hide();

	//Hides input that stores email
	$('#email3').hide();

	jQuery('.ajaxform').submit( function() {
		$.ajax({
			url     : $(this).attr('action'),
			type    : $(this).attr('method'),
			data    : $(this).serialize(),
			success : function( data ) {
				//Parses JSON data 
				var data = $.parseJSON(data);

				//Resets input highlights
				$('input').css('border','1px solid #999');

				//Clears input box
				$('#email').val('');

				if(data['status'] == true) {
					//Setting parameters for alertbox
					$("#alertbox").css('color','green');
					$("#alertbox").html(data["message"]);

					//Sets values to update form
					$('#person_id').val(data['person_id']);
					$('#firstname2').val(data['firstname']);
					$('#lastname2').val(data['lastname']);
					$('#email2').val(data['email']);
					$('#email3').val(data['email']);
					$('#address2').val(data['address']);
					$('#phone2').val(data['phone']);
					$('#email2').prop('disabled',true);

					//Shows form
					$('#form2').show();	
				}
				else {
					$('#email').css('border','1px solid red');

					//Setting parameters for alertbox
					$("#alertbox").css('color','red');
					$("#alertbox").html(data["message"]);
					
					//Hides form
					$('#form2').hide();	
				}			
			},
			error   : function(){
				alert('Something wrong');
			}
		});
		return false;
	});

	jQuery('.ajaxform2').submit( function() {
		$.ajax({
			url     : $(this).attr('action'),
			type    : $(this).attr('method'),
			data    : $(this).serialize(),
			success : function( data ) {
				//Parses JSON data 
				var data = $.parseJSON(data);

				//Resets input highlights
				$('input').css('border','1px solid #999');

				//Process properties based upon the status of errorcodes
				if(data['status'] == 'true') {
					//Change color of alert box
					$("#alertbox2").css('color','green');
				}
				else {
					//Change color of alert box
					$("#alertbox2").css('color','red');

					//Sets parameters for input boxes
					if(data['message'].indexOf('first') >= 0) {
						$('#firstname2').css('border','1px solid red');
					}
					if(data['message'].indexOf('last') >= 0) {
						$('#lastname2').css('border','1px solid red');
					}
					if(data['message'].toLowerCase().indexOf('email') >= 0) {
						$('#email2').css('border','1px solid red');
					}
					if(data['message'].indexOf('address') >= 0) {
						$('#address2').css('border','1px solid red');
					}
					if(data['message'].indexOf('phone') >= 0) {
						$('#phone2').css('border','1px solid red');
					}
				}
				//Display message into alert box
				$('#alertbox2').html(data['message']);		
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
