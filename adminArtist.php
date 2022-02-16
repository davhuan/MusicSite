<?php

	$script="artistFunctions.js";
	$title="Admin Artist";
	$accordion = TRUE;
	$jquery = TRUE;
  include("src/loginFunctions.php");//Lägger till loginfunction.php
	if(checkSession()==false){//kontrollerar om man är inloggad eller inte
		header("Location: login.php");//omplacera till loginsida
	}
		else{
		$admin = "secretpage";// variablar som admin används hemligsida.
	}

	include("incl/header.php");

?>
					<div id="content">

	<?php
		try{// funktionen kommer köras och fånger felmeddlande
			include("src/artistFunctions.php");//lägger till artistFunction.php som lägger i mappen
			include("src/uploadFunctions.php");//lägger till uploadfunction.php
           include("src/databaseFunctions.php"); //lägger till databaseFunction.php
			$db=myDBConnect();//Den skapar en database uppkopping som finns i databasefunkction.php
			printArtistForm();//skriver ut artistfomuläret
            
			if(isset($_POST['btnSave'])){ //om man trycker save knappen så ska ifsatsen köra igång
				if(empty($_POST['txtArtist']) ) {//Om man inte har valt en fil eller namn så kommer den slänga ett error
			      if(empty($_FILES['filePictureFileName'])) // om bilden är tomt
					$artist = $_POST['hidPictureFileName'];
				}
				else{
					if($_POST['hidId']!=''){//om hidId har fått ett värde så ska den updateras

						updateArtist($db, $_POST['hidId'], $_POST['txtArtist'], $_FILES['filePictureFileName']["name"], $_POST['hidPictureFileName']);//En uppdatering körs igång
					}
					else{

						if(!empty($artist)){//om den artisten namnet har hittats
								throw new Exception("Denna artist finns redan i databasen");//Slänger ett error meddelande när det finns samma artist
						}

						insertArtist($db, $_POST['txtArtist'], $_FILES['filePictureFileName']["name"]);//kör function och skickar en befintlig data.
				}
				}
			}
			if(isset($_POST['btnDelete'])){//om knapp delete har tryckts så ska function köra igång
				deleteArtist($db, $_POST['hidId'], $_POST['hidPictureFileName']);//tar bort id/fil

			}
		}
		catch(Exception $e){echo($e->getMessage());}//tar emot error

		try{
            
			listArtists($db);//Skrivar ut listartist i databasen.
           
		}
		catch(Exception $e){echo($e->getMessage());}//Om det inte fungera så får den felmeddelande
	?>
				
										</div>

<?php include("incl/footer.php");
