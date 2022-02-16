<?php

	/* Funktioner (inklusive parametrar) som beh�vs f�r att administrera en artister */

	/**
	*	Funktionen printArtistForm() skriver ut formul�ret (frmNewUpdateArtist) i vilket det g�r att skriva in en ny
	*	artist eller uppdatera en befintlig artist.
	*
	*	Funktionen tar inte emot n�gon data och returnerar heller ingen data.
	*/
    function printArtistForm() {
      // Här har jag kopierat formuläret som låg adminArtist.php, denna function kommer skriva ut formuläret.
    echo('  <h1>Admin Artist</h1>		<hr />



    						 <fieldset>
    							<legend>New/Edit Artist</legend>

    							<span id="jsErrorMsg" class="errorClass"></span>

    							<form action="adminArtist.php" method="post"name="frmNewUpdateArtist" id="frmNewUpdateArtist" enctype="multipart/form-data">

    								<input type="hidden" id="hidId" name="hidId" />
    								<input type="hidden" id="hidPictureFileName" name="hidPictureFileName" />
    								<label>
    									Artist
    									<br />
    									<input type="text" id="txtArtist" name="txtArtist" title="Artist"/>
    								</label>
    								<br />
    								<label>
    									Picture
    									<br />
    									<input type="file" id="filePictureFileName" name="filePictureFileName" title="Picture" />
    								</label>
    								<br />
    								<input type="submit" id="btnSave" name="btnSave" value="Save" />
    								<input type="button" id="btnReset" name="btnReset" value="Reset" />
    							</form>
    						</fieldset>
              ');
		}

	/**
	*	Funktionen listArtists s�ker ut samtliga artister som finns lagrade i databasen och skriver ut dessa som egna formul�r (frmArtist).
	*	Finns inga poster lagrade skriver funktionen ist�llet ut "Det finns inga artister i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBH Databaskoppling
	*/
	function listArtists($inDBH) {
		$sql = "SELECT * FROM tblartist";
    $args= array(); //array , värde

    $artists= myDBQuery($inDBH, $sql,$args);
    foreach($artists as $row)
    {
//skriver ut formulär, hämtart data
      $date=date('Y-m-d H:i', strtotime($row['changedate'])); // hämtar date, tid osv
     // echo('	<div id ="accordion">');
     // echo(' <h3>Artist</h3>');
      echo('<form action="adminArtist.php" method="post" name="frmArtist" enctype="multipart/form-data">');
      echo('id: ' . $row['id']  .  '<br />' . 'name: ' .  $row['name']  . '<br />' . 'picture: ' .  $row['picture']  . '<br />' . 'changedate: ' . $date  . '<br />');
      echo('<img src="upload_jpg/' . $row['picture'] . '" alt="' . $row['picture'] . '." class="imgAnimation" /><br />');
      echo('<input type="button" name="btnEdit" value="Edit" >');
      echo('<input type="submit" name="btnDelete" value="Delete" />');
      echo('<input type="hidden" name="hidId" value="' . $row['id'] . '" />');
      echo('<input type="hidden" name="hidPictureFileName" value="' . $row['picture'] . '" />');
      echo('<input type="hidden" name="hidArtist" value="' . $row['name'] . '" />');
      echo('</form>');
      echo('</div>');


	}
}
	/**
	*	Funktionen insertArtist sparar en ny artist till databasen samt anropar validateAndMoveUploadedFile() f�r att flytta den
	*	uppladdade jpg-filen till r�tt underkatalog.
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBH Databaskoppling
	*	@param string $inArtist Aristnamn
	*	@param string $inNewPictureFileName Filnamn (jpg-bilden)
	*/
    function insertArtist($inDBH, $inArtist, $inNewPictureFileName) {


      $args = array(
        'namn'=>$inArtist,
        'bild'=>$inNewPictureFileName);
  		$sql="INSERT INTO tblartist (name, picture) VALUES (:namn,:bild)";

  		myDBQuery($inDBH, $sql,$args);
        validateAndMoveUploadedFile('jpg');//validerar och flyttar lägger upp filen i jpg
		}

	/**
	*	Funktionen updateArtist uppdaterar en befinlig artist i databasen. Om en ny jpg-fil har angivits tar funktionen bort den gamla och
	*	anropar validateAndMoveUploadedFile() f�r att flytta den nya uppladdade jpg-filen till r�tt underkatalog.
	*	Funktionen returnerar ingen data men kastar ett undantag om n�got gick fel i samband med att den gamla jpg-filen skall tas bort.
	*
	*	@param resurce $inDBH Databaskoppling
	*	@param $inArtistId string Prim�rnyckeln f�r artisten som skall uppdateras
	*	@param string $inArtist Aristnamn
	*	@param string $inNewPictureFileName Filnamn p� den nya jpg-bilden
	*	@param string $inOldPictureFileName	Filnamn p� den gamla jpg-bilden
	*/
	function updateArtist($inDBH, $inArtistId, $inArtist, $inNewPictureFileName, $inOldPictureFileName) {
          $args = array(
            'id'=>$inArtistId,
            'name'=>$inArtist,
            'picture'=>$inNewPictureFileName,

          );
// Insperation fick jag från https://www.w3schools.com/php/php_mysql_update.asp , lösningen är att jag lade sql frågorna till en ifsats
            $sql = "UPDATE tblartist SET name='$inArtist'"; // updateras sätter namn
            if( !empty($inNewPictureFileName))  // om den inte är tomt så ska den köra ifsats
                $sql .= ", picture='$inNewPictureFileName'";  //sql fråga
            $sql .= "WHERE id=$inArtistId;";             //sql fråga
            if( !empty($inOldPictureFileName) )
                myDBQuery($inDBH, $sql,$args);
                validateAndMoveUploadedFile("jpg");  //anropar

                unlink($_SERVER["DOCUMENT_ROOT"]."/MusicSite/upload_jpg/".$inOldPictureFileName);


        }



	/**
	*	Funktionen deleteArtist tar bort en befinlig artist fr�n databasen. D�rtill tar funktionen bort den jpg-fil samt samtliga ogg-filer som
	*	artisten �r knuten mot.
	*	Funktionen returnerar ingen data men kastar ett undantag om n�got gick fel i samband med att jpg-filen eller ogg-filen/filerna skall tas bort.
	*
	*	@param resurce $inDBH Databaskoppling
	*	@param $inArtistId string Prim�rnyckeln f�r artisten som skall tas bort
	*	@param string $inPictureFileName Filnamn p� jpg-bilden
	*/
    function deleteArtist($inDBH, $inArtistId, $inPictureFileName) {
      $sql='DELETE  FROM tblartist WHERE id=:id';
      $args = array(
        'id'=>$inArtistId,
      ); // värde
  	myDBQuery($inDBH, $sql,$args);
  		unlink($_SERVER["DOCUMENT_ROOT"] . "/MusicSite/upload_jpg/" . $inPictureFileName); // tar bort filen från din dator
    }
