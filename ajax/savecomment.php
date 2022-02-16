<?php

	/*
		Spara den nya kommentaren i databasen.
	*/
	
	/**
	*	I savecomment skall en databaskoppling upprättas och därefter skall en ny kommentar sparas till databasen för det
	*	inkommande primärnyckel för song. Därefter skall dagens datum samt inkommande kommentar
	*	returneras som JSON data.
	*
	*   Kom ihåg att tvätta data, frigöra minnet från utsökningen, stänga ner databaskopplingen samt använda undantagshantering.
	*	
	*/
	
	//För test returneras dagens datum och en konstant i form av JSON: {"date" : "dagens datum", "comment" : "Detta är en kommentar"}.
//	header("Content-Type: application/json");
	
//	$jsonData = array("date" => date("Y-m-d"), "comment" => "Detta är en kommentar");
//	echo(json_encode($jsonData));

    include("../src/databaseFunctions.php");//inkluderar databasfunktioner
	$inDBConnection = myDBConnect();//startar en databas uppkoppling
	$comment=strip_tags($_POST["comment"]);//tar emot kommentaren och tarbort eventuella html taggar sql injection tvättas i pdo
	$songId=$_POST["id"];//tar emot id
		
	$SQLQuery="INSERT INTO tblcomment (text, songid) VALUES (?,?);";//skapar en sql query
	myDBQuery($inDBConnection, $SQLQuery, $comment, $songId);//skickar querien med värde till databasen och sparar dem
	
	$SQLQuery = "SELECT * FROM tblcomment WHERE songid=? ORDER BY id DESC LIMIT 1;";//skapar sql query
	$queryResult = myDBQuery($inDBConnection, $SQLQuery, $songId);//använder query för att hämta värdena från den nya kommentaren
	header("Content-Type: application/json");//förklarar vilken typ av innehåll den är 
	
	$jsonData = array("date" => $queryResult[0]["insertdate"], "comment" => $queryResult[0]["text"]);//skapar en array med värdena från kommentaren 
	echo(json_encode($jsonData));//skickar den nya kommentarens värden tillbaka till ajax

	?>