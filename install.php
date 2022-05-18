<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<title>
			install.php
		</title>
	</head>
	
	<body>
		<?php
			$dbname="lweb25";
			$userTable="utente";
			$phoneTable="telefono";
			$i=0;
						
			$connection=new mysqli("localhost","lweb25","lweb25");

			if(mysqli_errno($connection)){
				echo "errore";
			}

			/*CREAZIONE DBS*/

			$query= "CREATE DATABASE if not exists $dbname";
			if(mysqli_query($connection,$query)){
				echo "<h1>DBS creato</h1>";
			}	
			else {
				echo "<h1 style=\"color:red\">errore creazione DBS</h1>";
			}
			$connection->close();
			////////////////////////////////////////
			///////////////////////////////////////
			//CREAZIONE TABELLE DBS///////////////
			/////////////////////////////////////
			$connection=new mysqli("localhost","lweb25","lweb25",$dbname);

			if(mysqli_errno($connection))
				echo "<h1 style=\"color:red\">DBS non raggiungibile</h2>";
			/////TABELLA UTENTE
			$query= "CREATE TABLE if not exists $userTable(
				username VARCHAR(20) NOT NULL,
				password VARCHAR(20) NOT NULL,
				spesatotale VARCHAR(20) NOT NULL
				)";
			echo $query;
			if(mysqli_query($connection,$query)){
				echo "<h2 style=\"color:green\">tabella utente creata</h2>";
			}	
			else {
				echo "<h2 style=\"color:red\">errore creazione tabella utente</h2>";
			}
			/////TABELLA TELEFONO
			$query= "CREATE TABLE if not exists $phoneTable(";
			$query.="id INT NOT NULL AUTO_INCREMENT,";
			$query.="nome VARCHAR(20) NOT NULL,";
			$query.="prezzo DOUBLE NOT NULL,";
			$query.="PRIMARY KEY(id)";
			$query.=");";
			echo $query;
			if(mysqli_query($connection,$query)){
				echo"<h2 style=\"color:green\">tabella telefono creata</h2>";
			}	
			else {
				echo "<h2 style=\"color:red\">errore creazione tabella telefono</h2>";
			}
			
/////CONTROLLO ESISTENZA TABELLA////////////////
/*			
function if_table_exists ($conn,$tablename)
{
//controllo se il nome della tabella passato esiste nel db
$result = mysqli_query($conn,"SHOW TABLES LIKE '".$tablename."'");
//conto il numero di righe risultanti
$row=mysql_num_rows($result);
//$row è maggiore di 0
if($row>0)
{
return true;
}
return false;
}
//nel caso la funzione ci restituisce true, la tabella cercata è presente nel db
if( if_table_exists($connection,$phoneTable))
{
echo "La tabella esiste!";
}
else echo "not exist";
*/
			/////////////////////////////////
			////////////////////////////////
			/////////POPOLAMENTO TABELLE////
			///////////////////////////////
			$sql=array();

			$sql[0]= "INSERT INTO $phoneTable (nome, prezzo) VALUES (\"iphone10\", \"900\")";
            $sql[1]= "INSERT INTO $phoneTable (nome, prezzo) VALUES (\"iphone12\", \"1200\")";
            $sql[2]= "INSERT INTO $phoneTable (nome, prezzo) VALUES (\"samsung s9\", \"800\") ";
            $sql[3]= "INSERT INTO $phoneTable (nome, prezzo) VALUES (\"huawei\", \"500\") ";
            $sql[4]= "INSERT INTO $userTable (username, password, spesatotale) VALUES (\"luca\",\"luca\",\"0\") ";
            $sql[5]= "INSERT INTO $userTable (username, password, spesatotale) VALUES (\"andrea\",\"andrea\",\"0\") ";
            $sql[6]= "INSERT INTO $userTable (username, password, spesatotale) VALUES (\"prof\",\"prof\",\"0\") ";
			
			while($i<sizeof($sql)){
				echo "$sql[$i] \n <br />";
				if(mysqli_query($connection,$sql[$i])){
					echo "<h2 style=\"color:green\">popolamento riuscito</h2>";
				}	
				else {
					echo "<h2 style=\"color:red\">errore popolamento</h2>";
				}
				$i+=1;
			}
				
		?>
	
	</body>

</html>
