<?php

	$script="searchFunctions.js"; 
	$title="Search";
	$slimbox = TRUE;
	$jquery = TRUE;
	include("src/loginFunctions.php");//Lägger till loginFunction.php
	if(checkSession()==true){ //kontrollera om seassion är sant
		$admin = "secretpage";
	}
	include("incl/header.php");
?>
					<div id="content">
						
							<?php 
		try{
			include("src/searchFunctions.php");//Lägger till searchFunction.php
            include("src/databaseFunctions.php"); // inkluderar databasefuntion.php
			$db=myDBConnect();//Start en databaseuppkoppling.
			printSearchForm();//skriver ut formuläret
			if(isset($_POST['btnSearch'])){//Om knappen är tryckt så körs ifsastsen
				if(empty($_POST['txtSearch'])){//Om texten är tomt så körs throw
					throw new Exception("Sökfältet är tomt!");// slänger en felmeddelande
				}
				else{
					listSongs($db, strip_tags($_POST['txtSearch']));//visar song
					listArtists($db, strip_tags($_POST['txtSearch']));//visar Artisten.
				}
			}
		}
		
		catch(Exception $e){echo($e->getMessage());}//tar emot felmeddelende och skriver ut den.
	?>	
						
                        </div>
					

<?php include("incl/footer.php");