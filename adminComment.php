<?php
	
	$script="commentFunctions.js";
	$title="Admin comment";
	$accordion = TRUE;
	$jquery = TRUE;
	

	
    	require_once('src/databaseFunctions.php');
     
include("src/loginFunctions.php");//l�gger till loginFunction.php
	if(checkSession()==false){//kotrollerar om anv�ndare �r falsk.
		header("Location: login.php");//om anv�ndare �r inte inloggad s� kommer det bli omplacered till loginsida
	}
	else{//om anv�ndare �r inloggad redan-
		$admin = "secretpage";//variabeln f�r att admin ska aktivera i menyn.
	}
	include("incl/header.php");
	
?>
                         <meta charset="UTF-8">
						<div id="content">
							
				
                           

							
                            
                            
					<?php
                    try{            
                        include("src/commentFunctions.php");
                        $db = myDBConnect();
                    if (isset($_POST["btnDelete"])){// om delet knappen trycks s� ska ifsatsen k�ras ig�ng
                        deleteComment($db, $_POST['hidId']);//delet functionen k�rs ig�ng som tar bort commenterna fr�n databasen.
                    }
                    }
                      	catch(Exception $oE){echo($oE->getMessage());}//tar emot felmedelande fr�n f�reg�ende try
		
		try{// funktionen k�rs och fel f�rekommer avbryts koden och skickar ett fel medelande till n�stkommande catch
			listComments($db);//listar kommentarerna
		}
		catch(Exception $oE){echo($oE->getMessage());}//tar emot felmedelande fr�n f�reg�ende try  
                    ?>
							
						
							

						</div>

<?php include("incl/footer.php");