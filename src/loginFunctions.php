<?php
	/* Funktioner (inklusive parametrar) som beh�vs f�r att hantera anv�ndare och sessioner */

	/**
	*	Funktionen validateUser s�ker ut antalet poster som matchar $inUserName och $inPassWord och returnerar talet (0 eller 1).
	*
	*	@param resurce $inDBH Databaskoppling
	*	@param string $inUserName Anv�ndarnamn
	*	@param string $inPassWord L�senord
	*
	*	@return int Antalet rader som matchar s�kkriterierna
	*/
/*
    function validateUser($inDBH, $inUserName, $inPassWord) {

     $inUserName = mysqli_real_escape_string($inDBH, $inUserName);  // är man tvungen ha detta? upg står det, men får inte den att funka >.<
    	$inPassWord = mysqli_real_escape_string($inDBH, $inPassWord); //:(
// För det ska funka, skapa en ny användare med sh1 kryptering lösen
    $args = array(
      'user'=>$inUserName,
      'pass'=>$inPassWord,
    );

  $sql = "SELECT * FROM tbladmin WHERE username = '". $inUserName ."' ";
    	$sql .= "AND password = sha1('". $inPassWord ."');";
      $row = myDBQuery($inDBH, $sql,$args);
      return count($row);
    */   



        function validateUser($inDBH, $inUserName, $inPassWord) {
        $SQLQuery="SELECT * FROM tbladmin WHERE username=? AND password=?;";
		$row=myDBQuery($inDBH, $SQLQuery, $inUserName, hash("sha256", $inPassWord));
		return count($row);

	}
	/**
	*	Funktionen startSession() startar upp en session och sparar i denna sparar sessionsvariablerna usernamn och online.
	*	Funktionen tar inte emot n�gon data och returnerar heller ingen data.
	*/
	function startSession() {
		session_start();
		session_regenerate_id(true);
		$_SESSION["username"] = $_POST["username"];
		$_SESSION["datetime"] = date("Y-m-d H:i:s");
		$_SESSION["online"] = true;
	}

	/**
	*	Funktionen endSession() avslutar en befintlig session.
	*	Funktionen tar inte emot n�gon data och returnerar heller ingen data.
	*/
	function endSession() {


		$_SESSION = array();//Avmakerar alla sessionsvariablerna
//  http://php.net/manual/en/function.session-destroy.php		Koden där nere har tagit från
// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
// Om det är önskvärt att döda sessionen, radera också sessionskakan.
// Obs! Detta kommer att förstöra sessionen, och inte bara sessiondata!
// Den här anppassarr min kod för att döda session och session kakorna.
		session_unset();
		if (ini_get("session.use_cookies")) {
			$data = session_get_cookie_params();
			$path = $data["path"];
			$domain = $data["domain"];
			$secure = $data["secure"];
			$httponly = $data["httponly"];
			setcookie(session_name(), "", time() - 5000, $path, $domain, $secure, $httponly);
		}
	
		 session_destroy();
		
	}

	/**
	*	Funktionen checkSesion() kontrolleras om en session �r ig�ng och om s� �r fallet genererar ett nytt sessionsid och returnerar sant.
	*	�r ingen session ig�ng returneras falskt.
	*	Funktionen tar inte emot n�gon data.
	*
	*	@return boolean Om en anv�ndare �r p�loggad eller inte
	*/
	function checkSession() {
		// Hör kollar den sessioner.
		session_start(); //session startar igång
		$online = false;
		if (isset($_SESSION["online"])) {
			$online = true;
			session_regenerate_id(true);
		}
		else {
			endSession();
		}
		return $online;
		}
