<?php echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Inserisci</title>
	<style type="text/css">
		body{
				background-color:beige;
				text-align:center;
				font-family:Arial;
			}
			#header{
				background-color:blue;
				color:white;
				border-style:solid;
				border-color:black;
				display:flex;
				justify-content:center;
				font-family:Arial;
				font-size:30px;
			}
			#header ul{
				list-style-type:none;
			}
			#header a{
				text-decoration:none;
				color:white;
			}
			#header li{
				padding-right:20px;
				padding-left:20px;
				display:inline-block;
				opacity:90%;
			}
			#header li:hover{
				opacity:100%;
			}
			#main{
				display:flex;
				justify-content:center;
				padding:2%;
				font-size:30px;
			}
			.borderrow{
				background-color:blue;
				color:white;
			}
			@media all and (max-width: 550px){ /*da una disposizione in colonna mettendo in evidenza la il contenuto principale quando si rimpicciolisce la pagina*/
				#header ul{
					display:flex;
					flex-direction:column;
				}
			}
			</style>
</head>

<body>
	<div id="header">
		<ul>
			<li><a href="Logout.php" title="Logout">Logout</a></li>
		</ul>
	</div>
	</body>
	</html>