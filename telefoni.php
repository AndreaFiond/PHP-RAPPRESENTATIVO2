<?php echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Shop</title>
		<style type= "text/css">
		/*utilizziamo un layout holy grail responsive avente una zona header dedicata al menu con i servizi offerti
		una zona main suddivisa in due sezioni a destra � presente ci� che abbiamo aggiunto al carrello con il totale speso.
		A sinistra invece � presente una lista di telefoni da aggiungere al carrello*/
		body{
			font-family:sans-serif;
			display:flex;
			flex-direction:column;		/*impostiamo il body in modo da avere un layout a colonne*/
			text-align:center;
			font-size:20px;
			background-color:beige;
		}
		.main{
			display:flex;
			padding:1%;
			height:85%; 
		}
		#header{
			border-style:solid;
			border-color:black;
			background-color:blue;
			color:white;
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
		/*SEZIONE RIGHT*/
		#right{
			padding:5%;
			flex: 1 1 100px;
		}
		/*SEZIONE LEFT*/
		#left{
			padding:5%;
			flex: 1 1 100px;
			color:black;
		}
		
		@media all and (max-width: 550px){ /*da una disposizione in colonna mettendo in evidenza la il contenuto principale quando si rimpicciolisce la pagina*/
		.main{
			flex-direction:column;
			}
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
			<li><a href="telefoni.php" title="Shop">Shop</a></li>
			<li><a href="checkout.php" title="Checkout">Checkout</a></li>
			<li><a href="Logout.php" title="Logout">Logout</a></li>
		</ul>
	</div>
	<div class="main">
	<div id="left">
		<?php
			/*OSSERVAZIONE:
			se effettuiamo questo passaggio il web server acceder� all'area di memoria contenete proprio le informazioni dell'utente
			che ha effettuato una richiesta mandando al server anche il cookie di sessione, in questo modo il server ricorder� i dati
			e potr� aggiornarli
			session_start();
			echo $_SESSION['username'];*/
			$autocall=$_SERVER['PHP_SELF'];
			$telefonoTable="Telefono";
				session_start(); /*avviamo la sessione (va avviata per ogni pagina)*/
				require_once("connection.php");
				$sql= "SELECT * FROM $telefonoTable";
				$result=mysqli_query($connection,$sql); /*inviamo la query*/
				if($result){ /*se la query da risultato allora salviamo tutti i telefoni nell'array row usando un ciclo while*/
					echo"<h3>MODELLI DISPONIBILI</h3><hr>";
					echo"<form action = \"$autocall\" method=\"post\">";/*form con auto chiamata*/
					while($row=mysqli_fetch_array($result)){
						echo"<p><input type=\"radio\"name=\"id\" value=";echo $row['id'];echo ">";echo $row['nome'];echo"<strong>(Prezzo: ";echo $row['prezzo'];echo"&euro;)</strong></p>"; /*stampiamo i modelli e prezzi*/
					}
					echo"<input type=\"submit\"value=\"aggiungi al carrello\">";/*bottone action del form*/
					echo"</form>";
				}
				else /*caso query non valida*/
					echo "La query non da risultato";
		?>
		</div>
		<div id="right">
			<h3>CARRELLO</h3><hr>
			<?php 
			if(isset($_POST['svuota'])){ /*SE L'UTENTE DECIDE DI SVUOTARE IL CARRELLO ALLORA DEALLOCHIAMO LE VARIABILI DI SESSIONE E RIALLOCHIAMOLE*//*RICORDIAMO SEMPRE ISSET PER VARIABILI SESSIONE O POST*/
				unset($_SESSION['spesa_attuale']);
				unset($_SESSION['carrello']);
				$_SESSION['spesa_attuale']=0; /*queste variabili session stanno nel server*/
				$_SESSION['carrello']=array();
			}
			if(isset($_SESSION['username']) && isset($_SESSION['password'])){ //SE abbiamo selezionato qualcosa e se siamo loggati
				if(isset($_POST['id'])){
				$id=$_POST['id']; //id del telefono scelto
				//cerchiamo il telefono selezionato nel dbs avendo ricevuto l'id
				$sql="SELECT * FROM $telefonoTable WHERE id = '$id'";
				$result=mysqli_query($connection,$sql); //inviamo query
				if($result){ //query valida ora estraiamo informazioni dal risultato della query
					if($row=mysqli_fetch_array($result)){ //se il telefono � presente nel dbs
						array_push($_SESSION['carrello'],$row['nome']); //salviamo il modello nella sessione in un apposita variabile array
						$_SESSION['spesa_attuale']+=$row['prezzo']; //aggiorniamo spesa corrente
					}
				}
				else{
					echo "query non valida";
				}
			}
			}
			else{
				echo "<script> 
						alert(\"Azione non permessa effettuare login\");
						</script>";
			}
			if(isset($_SESSION['carrello'])&& isset($_SESSION['spesa_attuale'])){//se il carrello non � vuoto 
							foreach($_SESSION['carrello'] as $item){ /*facciamo un ciclo foreach per stampare il contenuto*/
								echo"<p>";	
								echo $item; /*stampiamo tutti i modelli che sono stati aggiunti al carrello*/
								echo "</p>";
							}
							echo "<hr><strong>Totale spesa: ";echo $_SESSION['spesa_attuale']; echo"&euro;</strong>";
						}
			/*form per svuotare il carrello*/
			echo "<form action \"$autocall\" method=\"POST\">
			<p><input type=\"submit\" name=\"svuota\" value=\"Svuota\"></p>
			</form>"; //opzione per svuotare il carrello 
			
			/*form per andare al checkout*/
			echo "<form action =\"checkout.php\" method=\"POST\">
			<p><input type=\"submit\" name=\"checkout\" value=\"Checkout\"></p>
			</form>"; //opzione per effettuare checkout
			
			$connection->close(); /*chiudiamo connessione con dbs*/
			?>
		</div>
		</div>
	</body>

</html>