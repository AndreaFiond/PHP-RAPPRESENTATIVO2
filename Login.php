<?php echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>Login.php</title>
		<style type="text/css">
			#contenitore{
				background-color:beige;
				margin-left:10%;
				margin-right:10%;
				display:flex;       /*per centrare contenuto*/
				justify-content:center;
				border-style:solid;
				border-color:blue;
			}
		</style>
	</head>
	<!-- dobbiamo connetterci al dbs (realizzeremo uno script apposito in modo da evitare di riscriverlo ogni volta, al quale accederemo con la funzione php
		require_once(connectiondbs.php);
		successivamente dobbiamo estrarre dal dbs le tabelle 
		1)username
		2)password
		e salvarle in due variabili $arr_username $arr_pwd.
		Fatto questo controlliamo se i dati username e password ricevuti con post sono contenuti nel dbs;
		in caso positivo saremo reindirizzati attraverso la funzione header() in una pagina dedicata agli acquisti;
		in caso negativo torneremo alla pagina di login e verrà mostrato un messaggio di errore login -->
		
	<body>
	<h1 style="margin-top:5%;display:flex;justify-content:center;color:blue; font-family:Arial">EFFETTUARE LOGIN</h1>
		<div id="contenitore">
			<form action="Login.php" method="post">
				<p>Username: <input type="text" name="username"></p>
				<p>Password: <input type="password" name="password"></p>
				<p style="display:flex; justify-content:center"><input type="submit" name="login" value="login">
			</form>
		</div>
		<?php
		$username=$_POST['username'];
		$password=$_POST['password'];
		require_once("connection.php");
			$sql= "SELECT * FROM Utente WHERE username='$username' AND password='$password'"; /*realizziamo la query che controlla se i dati ricevuti via POST sono nel dbs*/
			$queryresult= mysqli_query($connection,$sql); /*mandiamo la query al dbs*/
			if($queryresult){ /*se la query da un risultato valido allora verifichiamo che l'utente esista*/
				$row = mysqli_fetch_array($queryresult); /*salviamo l'utente e le sue informazioni in un array*/
				if($row){ /*in questo caso l'utente esiste allora avviamo una sessione e salviamo la spesa totale*/
					printf("Login effettuato<br />");
					session_start();
					$_SESSION['totalespeso']=$row['totalespeso'];/*salviamo in una sessione i dati ciò implica l'invio di un cookie al web browser che ci sarà reinviato ogni qual volta esso richiederà questa pagina*/
					$_SESSION['datalogin']=time();
					$_SESSION['username']=$username;
					$_SESSION['password']=$password;
					/*a questo punto dovremo essere reindirizzati in una pagina dove poter effettuare acquisti*/
					header('Location: telefoni.php'); /*header indirizza a quella pagina*/
					/*echo"Benvenuto ";echo $row['username'];echo "<br />Totale speso=";echo $row['totalespeso'];echo"$"; /*stampiamo messaggio di benvenuto all'utente
					echo"<br />Orario collegamento:";echo $_SESSION['datalogin'];*/
					exit(); /*chiudiamo la sessione*/
				}
				else {/*l'utente non esiste*/
					echo"<h1 style=\"color:red\"> Credenziali non corrette </h1><hr>";
				}
			}
			else { /*se non siamo riusciti ad accedere alla tabella*/
				printf("Ops... la query non da risultato!");
				exit();
		}
		$connection->close(); /*chiudiamo connessione con dbs*/
		?>
	
	
	</body>



</html>