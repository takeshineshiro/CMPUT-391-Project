<?php
	require('database/dbconnect.php');

	$database dbConnect();
	
?>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="stylesheets/generalstylesheet.css">
		<title></title>
	</head>
	<body>
		<div id="page-wrap">
			<div id="header">
				<div id="titlebar">
					<h1>Radiology Information System</h1>
				</div>
			</div>

				<div id="content-wrap">
					<h2>User Management System</h2>
					<form name="form1" method="post" action="createuser.php">
						Username:<input name="username" type="text" id="username"></br></br>
						Password:<input name="password" type="text" id="password"></br></br>
						<input type="submit" name="Submit" value="Login">
					</form>

				</div>


			<div id="footer">

			</div>
		</div>
			

	</body>

</html>
