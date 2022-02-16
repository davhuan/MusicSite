<?php

	$script="songFunctions.js";
	$title="Admin song";
	$accordion = TRUE;
	$jquery = TRUE;
	include("src/loginFunctions.php");// Lägger till loginFuncttion.php , man skriver in sögvägen vilken fil man vill att den ska inkludera
	if(checkSession()==false){//om funktionen returnerar falsk så kommer användare bli omplacerad.
		header("Location: login.php");//Användare kommer hamna i login.php
	}
	else{
		$admin = "secretpage";//Det här används bara admin
	}




	include("incl/header.php");

?>
 <div id="content">
	<?php
		try{// Här körs try catch function att man provar och fångar fel osv.
			include("src/songFunctions.php");//Lägger till songFunction.php
			include("src/uploadFunctions.php");//Lägger till uploadFunction.php
            include("src/databaseFunctions.php"); //Lägger till databaseFunction.php så man kan köra kopplingen som databsefunction har
			$db=myDBConnect();//Här startar man en database uppkoppling.
			printSongForm($db);//Här skriver man ut formuläret som finns i songFunction.php.
			if(isset($_POST['btnSave'])){//om knappen save trycks på
						if(empty($_POST['txtTitle'])){//lägg till post och files
							throw new Exception("Fältet fårinte vara tomt!");//varning som kastas till catch
							if(empty($_FILES['fileSoundFileName'])) // om bilden är tomt
						$artist = $_POST['hidSoundFileName'];
						}
						else{
							if($_POST['hidId']!=''){//om hid id är tomt
// en updaterng ska köras igång om det finns ändring
							updateSong( $db, $_POST["hidId"], $_POST["selArtistId"], $_POST["txtCount"], $_POST["txtTitle"], $_FILES["fileSoundFileName"]["name"], $_POST["hidSoundFileName"] );
							}
							else{
								if(!empty($artist)){//om den artisten namnet har hittats
										throw new Exception("Denna artist finns redan i databasen");//Slänger ett error meddelande när det finns samma artist
								}

								insertSong($db, $_POST['selArtistId'], $_POST['txtCount'], $_POST['txtTitle'], $_FILES['fileSoundFileName']["name"]);//kör insert song om låten inte ska updateras
							}
						}
					}
			if(isset($_POST['btnDelete'])){//Om man trycker på delet knapp så kommer denna ifsats köra igång
				deleteSong($db, $_POST['hidId'], $_POST['hidSoundFileName']);//tar bort id och filen.
			}
		}
		catch(Exception $e){echo($e->getMessage());}//Här fångas det felmeddelande.

		try{// funktionen körs och fel förekommer avbryts koden och skickar ett fel medelande till nästkommande catch
			listSongs($db);//Skriver ut listsong
		}
		catch(Exception $e){echo($e->getMessage());}//fångar felmeddelanden
	?>
</div>


<?php include("incl/footer.php"); ?>
