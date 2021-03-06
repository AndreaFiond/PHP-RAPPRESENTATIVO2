<?php echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<!-- in questa pagina verrà stampato il totale della spesa riprendendo i dati memorizzati nella sessione
				e verrà aggiornata la spesa attuale dell'utente nel dbs -->
	<head>
		<title>Arrivederci</title>
		<style type="text/css">
			body{
				background-color:beige;
				font-family:Arial;
				display:flex;
				justify-content:center;
			}
			#content{
				border-style:solid;
				border-color:blue;
				padding:5%;
				text-align:center;
			}
			#content table{
				font-size:25px;
				border: thin blue;
			}
		</style>
	</head>
	<body>
		
	<div id="content">
		<?php
				session_start(); //avviamo la sessione
				require_once("connection.php");
				
				if(isset($_SESSION['carrello']) && isset($_SESSION['spesa_attuale'])){
					//ora stampiamo il contenuto totale la spesa effettuata e un messaggio di arrivederci
					echo "<h1 style=\"color: blue\"> GRAZIE PER AVER ACQUISTATO I SEGUENTI PRODOTTI</h1>";
					foreach($_SESSION['carrello'] as $item){
						echo "<p style=\"font-size:30px;color:blue;\">$item <p>";
					}
					echo "<p style=\"color:red;font-size:30px\"> Per un totale di "; echo $_SESSION['spesa_attuale']; echo"&euro;</p>";
					/*ora aggiorniamo la spesa dell'utente nel dbs*/
					$username=$_SESSION['username'];
					$totalespeso=$_SESSION['totalespeso'];
					$update= $totalespeso+$_SESSION['spesa_attuale']; /*nuovo valore spesa totale*/
					$sql="UPDATE Utente SET totalespeso='$update' WHERE username='$username'"; /*aggiorniamo il dbs con metodo UPDATE e SET*/
					$_SESSION['totalespeso']=$update;
					if(mysqli_query($connection,$sql)){ /////stampiamo un resoconto dell'utente
						$username=$_SESSION['username'];
						$datalogin=$_SESSION['datalogin'];
						$totalespeso=$_SESSION['totalespeso'];
						echo "<h1 style=\"color:red\">Arrivederci !</h1>";
						echo "<table style=\"margin-right:auto; margin-left:auto; margin-top:5%;\"border=\"1px\"> <tr><td><strong>Username</strong></td><td>$username</td></tr>
						<tr><td><strong>Data login</strong></td><td>$datalogin</td></tr>
						<tr style=\"background-color:red;\"><td><strong>Spesa totale utente</strong></td><td>$totalespeso &euro;</td></tr>";
					}
				}
				else /*altrimenti stampiamo carrello vuoto*/
					echo "<h1 style=\"color:red\">CARRELLO VUOTO</h1>";
				echo "<form action=\"telefoni.php\" method=\"post\">
						<input type=\"submit\" name=\"return\" value=\"Torna al negozio\">
					</form>";
				$connection->close();/*chiudiamo connessione con dbs*/
		?>
	</div>
	</body>
</html>