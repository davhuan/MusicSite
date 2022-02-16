<?php

	/*
		Öka tblsong.count med ett och spara i databasen.
	*/
	
	/**
	*	I likesong.php skall en koppling mot databasen upprättas och därefter skall antalet "gilla" (count) ökas med
	*	ett för inkommande primärnyckel för song. Därefter skall antalet "gilla" (count) på nytt sökas ut från databasen
	*	och returneras som JSON data.
	*   Kom ihåg att tvätta data, frigöra minnet från utsökningen, stänga ner databaskopplingen samt använda undantagshantering.
	*	
	*/
	
	//För test returnerars konstanten 100 i form av JSON: {"gilla" : "100"}.
	
	//header("Content-Type: application/json");
	
	//$jsonData = array("gilla" => "100");
	//echo(json_encode($jsonData));

include("../src/databaseFunctions.php");//inkluderar databasfunktioner
	$inDBConnection = myDBConnect();//startar en databas uppkoppling
	$SQLQuery = "UPDATE tblsong SET count=? WHERE id=?;";//skapar query
	myDBQuery($inDBConnection, $SQLQuery, $_POST["gilla"]+1, $_POST["id"]);//skickar query till databasen
	
	$SQLQuery = "SELECT count FROM tblsong WHERE id =?;";//skapar query
	$queryResult = myDBQuery($inDBConnection, $SQLQuery, $_POST["id"]);//skickar query
	header("Content-Type: application/json");//förklarar innehålls typen
		
	$jsonData = array("gilla" => $queryResult[0]["count"]);//skapar en array med den nya like counten
	echo(json_encode($jsonData));//returnerar den nya counten till ajaxen
	
	
	?>