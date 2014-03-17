<?php

//Inserts general functions
require('/compsci/webdocs/kjross/web_docs/usermanagement/php/processfield.php');
require('/compsci/webdocs/kjross/web_docs/usermanagement/php/checkfieldlength.php');
require('/compsci/webdocs/kjross/web_docs/usermanagement/php/checkfieldempty.php');

//Create errorcode array that hold status of errors and messages
$errorcode = array(true,'');

//Processes fields text
$d_email = strtolower(processField($_POST['email']));
$p_email = strtolower(processField($_POST['email2']));


//Checks that fields arent empty
$errorcode = checkFieldEmpty($d_email,'Please enter your doctors email <br/>',$errorcode);
$errorcode = checkFieldEmpty($p_email,'Please enter your patients email <br/>',$errorcode);

//Checks that fields are appropriate size
$errorcode = checkFieldLength(128,$d_email,"Please enter a doctors email with less then 128 characters <br/>",$errorcode);
$errorcode = checkFieldLength(128,$p_email,"Please enter a patients email with less then 128 characters <br/>",$errorcode);

//If passes all checks
if($errorcode[0]) {
	require('/compsci/webdocs/kjross/web_docs/database/dbconnect.php');
	require('/compsci/webdocs/kjross/web_docs/database/executecommand.php');

	//Establish connection to database
	$conn = dbConnect();

	//Checks if email exists within person
	$errorcode = checkEmailExists($conn,$d_email,$errorcode,'Doctor');
	$errorcode = checkEmailExists($conn,$p_email,$errorcode,'Patient');

	//If emails exists
	if($errorcode[0]) {

		//Checks if family doctor entry is unique
		$row = checkUniqueFamilyDoctor($conn,$p_email,$d_email,$errorcode);
		
		//if unique entry in family_doctor
		if($row[0][0]) {

			//SQL command for entering values into family_doctor
			$sql = 'INSERT INTO family_doctor VALUES (\''.$row[1][0][0].'\',\''.$row[2][0][0].'\')';

			//Executes sql command
			$num = executeCommand($conn,$sql);

			//Closes connection
			oci_close($conn);

			if($num[1]) {
				//Returns status of .php code and messages
				echo json_encode(array('status'=>'true','message'=>'Family doctor entry created: '.$d_email.' and '.$p_email.'<br/>'));
			}
			else {
				//Returns status of .php code and messages
				echo json_encode(array('status'=>false,'message'=>'Error executing command to database'));
			}
		}
		else {
			//Closes connection
			oci_close($conn);
			
			//Returns status of .php code and messages
			echo json_encode(array('status'=>$row[0][0],'message'=>$row[0][1]));

		}
	}	
	else {
		//Closes connection
		oci_close($conn);
		
		//Returns status of .php code and messages
		echo json_encode(array('status'=>$errorcode[0],'message'=>$errorcode[1]));
	}	
}
else {
	//Returns status of .php code and messages
	echo json_encode(array('status'=>$errorcode[0],'message'=>$errorcode[1]));
}

//Checks if email provided exists in persons
function checkEmailExists($conn,$email,$errorcode,$typeUser) {
	//Executes sql command
	$num = executeCommand($conn,'SELECT COUNT(*) FROM persons p WHERE p.email =\''.$email.'\'');

	//If oci_parse doesnt find email within persons
	if($num[0][0] == 0) {
		$errorcode[1] =  $errorcode[1].$typeUser.' doesnt exist with that email. Insert new email or create person with that email. <br/>';
		$errorcode[0] = false;	
	}
	return $errorcode;
}

//Checks if family doctor entry is unique
function checkUniqueFamilyDoctor($conn,$p_email,$d_email,$errorcode) {
	//Getting person_id for doctor
	$p1 = executeCommand($conn,'SELECT p.person_id FROM persons p WHERE p.email =\''.$d_email.'\'');
	
	//Getting person_id for patient
	$p2 = executeCommand($conn,'SELECT p.person_id FROM persons p WHERE p.email =\''.$p_email.'\'');

	//Check family_doctor row is unique
	$num = executeCommand($conn,'SELECT COUNT(*) FROM family_doctor f WHERE f.doctor_id =\''.$p1[0][0].'\' AND f.patient_id =\''.$p2[0][0].'\'');

	//If oci_parse doesnt find email within persons
	if($num[0][0] != 0) {
		$errorcode[1] = 'Family doctor entry with patients and doctors specified already exists';
		$errorcode[0] = false;	
	}

	//Both person_id's are the same
	if($p1[0][0] == $p2[0][0]) {
		$errorcode[1] = 'Emails are the same make sure doctors and patients emails are unique';
		$errorcode[0] = false;	
	}
	return array($errorcode,$p1,$p2);
}

?>
