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
				margin-left:auto;
				margin-right:auto;
				display:flex;       
				justify-content:space-around;
				align-items:center;
				border-style:solid;
				border-color:blue;
				font-size:25px;
				height:30%;
				width:60%;
			}
		</style>
		<script type="text/javascript">
			function formvalidator(){
				var usr = document.forms['userform']['username'].value; //assegnamo ad usr il valore di username
				var pwd= document.forms['userform']['password'].value;
				if(usr == null || pwd == null || usr == "" || pwd == ""){
					alert ("Dati mancanti");
					return false;
				}
				return true;
			}
		</script>
	</head>
	<!-- dobbiamo connetterci al dbs (realizzeremo uno script apposito in modo da evitare di riscriverlo ogni volta, al quale accederemo con la funzione php
		require_once(connectiondbs.php);
		successivamente dobbiamo estrarre dal dbs le tabelle 
		1)username
		2)password
		e salvarle in due variabili $arr_username $arr_pwd.
		Fatto questo controlliamo se i dati username e password ricevuti con post sono contenuti nel dbs;
		in caso positivo saremo reindirizzati attraverso la funzione header() in una pagina dedicata agli acquisti;
		in caso negativo torneremo alla pagina di login e verr? mostrato un messaggio di errore login -->
		
	<body>
	<h1 style="margin-top:5%;display:flex;justify-content:center;color:blue; font-family:Arial">EFFETTUARE LOGIN</h1>
		<div id="contenitore">
			<form name="userform" action="Login.php" method="post" onsubmit="return formvalidator()">
				<p>Username: <input type="text" name="username"></p>
				<p>Password: <input type="password" name="password"></p>
				<p style="display:flex; justify-content:center"><input type="submit" name="login" value="login"></p>
			</form>
			
			<form name="admin" action="admin.php" method="post">
			<p style="display:flex; justify-content:center"><input type="submit" name="admin" value="Accedi come amministratore" > </p>
			</form>
		</div>
		<?php
		if(isset($_POST['login'])){ //se abbiamo compilato la form
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
					$_SESSION['totalespeso']=$row['totalespeso'];/*salviamo in una sessione i dati ci? implica l'invio di un cookie al web browser che ci sar? reinviato ogni qual volta esso richieder? questa pagina*/
					$_SESSION['datalogin']=time();
					$_SESSION['username']=$username;
					$_SESSION['password']=$password;
					$_SESSION['spesa_attuale']=0; /*queste variabili session stanno nel server*/
					$_SESSION['carrello']=array();
					/*a questo punto dovremo essere reindirizzati in una pagina dove poter effettuare acquisti*/
					header('Location: telefoni.php'); /*header indirizza a quella pagina*/
					/*echo"Benvenuto ";echo $row['username'];echo "<br />Totale speso=";echo $row['totalespeso'];echo"$"; /*stampiamo messaggio di benvenuto all'utente
					echo"<br />Orario collegamento:";echo $_SESSION['datalogin'];*/
				}
				else {/*l'utente non esiste*/
					echo "<script> alert(\"Dati errati\"); </script>";
				}
			}
			else { /*se non siamo riusciti ad accedere alla tabella*/
				printf("Ops... la query non da risultato!");
			}
			$connection->close(); /*chiudiamo connessione con dbs*/
		}
		?>
	
	
	</body>



</html>