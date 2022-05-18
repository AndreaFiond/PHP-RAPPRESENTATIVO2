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
		</style>
	</head>
	<body>
		
	<div id="content">
		<?php
			try{ /*gestiamo con try catch le possibili eccezioni sql*/
				session_start(); //avviamo la sessione
				$connection=new mysqli("localhost","root","","movie"); //accesso al dbs
				
				if($_SESSION['carrello'] && $_SESSION['spesa_attuale']){
					//ora stampiamo il contenuto totale la spesa effettuata e un messaggio di arrivederci
					echo "<h1 style=\"color: blue\"> GRAZIE PER AVER ACQUISTATO I SEGUENTI PRODOTTI</h1>";
					foreach($_SESSION['carrello'] as $item){
						echo "<p style=\"font-size:30px;color:blue;\">$item <p>";
					}
					echo "<p style=\"color:red;font-size:30px\"> Spesa totale: "; echo $_SESSION['spesa_attuale']; echo"&euro;</p>";
					/*ora aggiorniamo la spesa dell'utente nel dbs*/
					$username=$_SESSION['username'];
					$totalespeso=$_SESSION['totalespeso'];
					$update= $totalespeso+$_SESSION['spesa_attuale']; /*nuovo valore spesa totale*/
					$sql="UPDATE utente SET totalespeso='$update' WHERE username='$username'"; /*aggiorniamo il dbs con metodo UPDATE e SET*/
					if(mysqli_query($connection,$sql))
						echo "<h1 style=\"color:red\">Arrivederci !</h1>";
				}
				else /*altrimenti stampiamo carrello vuoto*/
					echo "<h1 style=\"color:red\">CARRELLO VUOTO</h1>";
				echo "<form action=\"telefoni.php\" method=\"post\">
						<input type=\"submit\" name=\"return\" value=\"Torna al negozio\">
					</form>";
				exit(); /*chiudiamo la sessione*/
				$connection->close();/*chiudiamo connessione con dbs*/
			}
			catch(Exception $e){
				echo "<h1 style=\"color:red\">ERRORE DI CONNESSIONE CON IL DBS</h1>";
			}
		
		?>
	</div>
	</body>
</html>