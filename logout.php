<?php
	$title="Logout";
	include("incl/header.php");
    include("src/loginFunctions.php");
       if(checkSession()){//Kontrollere om den är inloggad eller inte
		  endSession();//Den avslutar inloggning - avslutar den session man va inne förut typ
	    }
            else{// Den här körs om man inte är inloggad och ska man åka direkt till login sidan
	        	header("location: login.php");//redirect till login.php
         	}
?>

				<div id="content">
					
					<h1> You are no longer logged on!</h1>
					<hr />

                </div>

<?php 
	include("incl/footer.php");
?>