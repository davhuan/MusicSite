<?php  
	$title="Login";
	include("incl/header.php");
   
    
	
?>
					<div id="content">
					
						<h1><?php echo($title); ?></h1>
						<hr />
						
						<?php 
							try{// Functionen körs, fel kan komma -try, catch
								include("src/loginFunctions.php");//inkluderar loginfunction.php
                                include("src/databaseFunctions.php");//inkluderar databaseFunction.php
								$db=myDBConnect();//startar databas uppkoppling
								//Vissa delar är tagen från R4 Peter bellström, denna anppsar min lösningen när användare trycker på login knappen - skrivit lösen ord och användarnman så loggas man in.
								  if (checkSession()) {//Checksession körs igång och kollar om det går bra
									header("location: adminArtist.php");//omplacerar  till adminArtist.php
									exit();//stänger av funktionen
								}
								
								if(isset($_POST['btnLogin'])){//När man trycker login knappen så kör denna igång funktionen
                                    if(empty($_POST['txtUserName'])||empty($_POST['txtPassWord'])){//Om användare och, eller lösen är toma så ska det kasta ett felmeddelande 
										 throw new Exception("Du har glömt fylla in lösen och användare!");//kaster en felmeddelande 
									}
                                    else{
									if(validateUser($db, $_POST["txtUserName"], $_POST["txtPassWord"]) === 1){ //om det finns lösenord och användarnamn rätt, så ska den retunera 1 och då ska man kunna logga in
                                                startSession();//startar seassion
                                                header("location: adminArtist.php");
                                                exit; //avlsuter funktionen
                                    } 
                                        else{
                                                throw new Exception("<p>Fel användarnamn och/eller lösenord</p>");
                                        }
                                    }
								}
				               }
							
							
							catch(Exception $e){echo($e->getMessage());}//tar emot felmedelande
							
						?>
						
						<fieldset>
						  <legend>Type username and password</legend>
						   <form action="login.php" method="post" name="frmLogin" >
								<label>
									Name
									<br />
									<input type="text" name="txtUserName" id="txtUserName" title="Username" placeholder="Type your username!" autofocus="autofocus" required="required" />
								</label>
								<br />
								<label>
									Password
									<br />
									<input type="password" name="txtPassWord" id="txtPassWord" title="Password" placeholder="Type your Password!" required="required" />
								</label>
								<br />
								<input type="submit" name="btnLogin" id="btnLogin" value="Login" />
								<input type="reset" name="btnReset" id="btnReset" value="Reset" />
						  </form>
						</fieldset>
					</div>

<?php include("incl/footer.php");