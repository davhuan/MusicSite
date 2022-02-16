<?php
	
	$script="commentFunctions.js";
	$title="Admin comment";
	$accordion = TRUE;
	$jquery = TRUE;
	

	
    	require_once('src/databaseFunctions.php');
     
include("src/loginFunctions.php");//lägger till loginFunction.php
	if(checkSession()==false){//kotrollerar om användare är falsk.
		header("Location: login.php");//om användare är inte inloggad så kommer det bli omplacered till loginsida
	}
	else{//om användare är inloggad redan-
		$admin = "secretpage";//variabeln för att admin ska aktivera i menyn.
	}
	include("incl/header.php");
	
?>
                         <meta charset="UTF-8">
						<div id="content">
							
				
                           

							
                            
                            
					<?php
                    try{            
                        include("src/commentFunctions.php");
                        $db = myDBConnect();
                    if (isset($_POST["btnDelete"])){// om delet knappen trycks så ska ifsatsen köras igång
                        deleteComment($db, $_POST['hidId']);//delet functionen körs igång som tar bort commenterna från databasen.
                    }
                    }
                      	catch(Exception $oE){echo($oE->getMessage());}//tar emot felmedelande från föregående try
		
		try{// funktionen körs och fel förekommer avbryts koden och skickar ett fel medelande till nästkommande catch
			listComments($db);//listar kommentarerna
		}
		catch(Exception $oE){echo($oE->getMessage());}//tar emot felmedelande från föregående try  
                    ?>
							
						
							

						</div>

<?php include("incl/footer.php");