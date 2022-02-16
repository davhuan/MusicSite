<?php
	/* Funktioner (inklusive parametrar) som beh�vs f�r att administrera en s�ng */

	/**
	*	Funktionen printSongForm() skriver ut formul�ret (frmNewUpdateSong) i vilket det g�r att skriva in en ny
	*	s�ng eller uppdatera en befintlig s�ng. Funktionen s�ker ut samtliga artister i databasen och listar dessa som
	*	valbara poster i selArtistId. Funktionen returnnerar ingen data.
	*
	*	@param resurce $inDBH Databaskoppling
	*/
    function printSongForm($inDBH) {
          $sql = "SELECT * FROM tblartist";

			echo('				<h1>Admin Song</h1>
						<hr />




						<fieldset>
							<legend>New/Edit Song</legend>

							<span id="jsErrorMsg" class="errorClass"></span>

							<form action="adminSong.php" method="post" id="frmNewUpdateSong" name="frmNewUpdateSong" enctype="multipart/form-data">

							<input type="hidden" id="hidId" name="hidId" />
								<input type="hidden" id="hidSoundFileName" name="hidSoundFileName" />
								<label>
									Artist
									<br />
									<select id="selArtistId" name="selArtistId" title="Artist" autofocus="autofocus">
									<option value="0">Choose Artist</option>');

                $args= array();

                  $artists = myDBQuery($inDBH, $sql,$args);
                  foreach($artists as $row){

											echo('<option value="' . $row['id'] . '">' . $row['name'] . '</option>');
										}
										echo(	'	</select>
                								</label>
                								<br />

                								<label>
                									Song
                									<br />
                									<input type="text" id="txtTitle" name="txtTitle" title="Title"/>
                								</label>
                								<br />

                								<label>
                									Sound
                									<br />
                									<input type="file" id="fileSoundFileName" name="fileSoundFileName" title="File" />
                								</label>
                								<br />

                								<label>
                									Count
                									<br />
                									<input type="text" id="txtCount" name="txtCount" title="Count" />
                								</label>
                								<br />

                								<input type="submit" id="btnSave" name="btnSave" value="Save" />
                								<input type="button" id="btnReset" name="btnReset" value="Reset" />

                							</form>

                						</fieldset>');
		}

	/**
	*	Funktionen listSongs s�ker ut samtliga s�nger som finns lagrade i databasen och skriver ut dessa som egna formul�r (frmSong).
	*	Finns inga poster lagrade skriver funktionen ist�llet ut "Det finns inga s�nger i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBH Databaskoppling
	*/
    function listSongs($inDBH) {

			$sql="SELECT * FROM tblsong";

      $args= array();

      $song= myDBQuery($inDBH, $sql,$args);
      foreach($song as $row)
      {


			$date=date('Y-m-d H:i', strtotime($row['changedate']));
   //   echo('	<div id ="accordion">');
			echo('<form action="adminSong.php" method="post" name="frmSong">');
			echo('id: ' . $row['id']  .  '<br />' . 'title: ' . $row['title']  . '<br />' . 'sound: ' . $row['sound']  . '<br />' . 'count: ' . $row['count']  . '<br />' . 'changedate: ' . $date  . '<br />');
			echo('<input type="hidden" name="hidId" value="' . $row['id'] . '" />');
			echo('<input type="hidden" name="hidArtistId" value="' . $row['artistid'] . '" />');
			echo('<input type="hidden" name="hidTitle" value="' . $row['title'] . '" />');
			echo('<input type="hidden" name="hidSoundFileName" value="' . $row['sound'] . '" />');
			echo('<input type="hidden" name="hidCount" value="' . $row['count'] . '" />');
			echo('<audio controls="controls"><source src="upload_ogg/' . $row['title'] . '.ogg" />stödjer inte ljud format</audio><br />');
			echo('<input type="button" name="btnEdit" value="Edit" >');
			echo('<input type="submit" name="btnDelete" value="Delete" />');
			echo('</form>');
      echo('</div>');
		}
		}

	/**
	*	Funktionen insertSong sparar en ny s�ng till databasen samt anropar validateAndMoveUploadedFile() f�r att flytta den
	*	uppladdade ogg-filen till r�tt underkatalog.
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBH Databaskoppling
	*	@param string $inArtistId Prim�rnyckeln f�r artisten som knyts mot s�ngen
	*	@param string $inCount Antalet "gilla" (count)
	*	@param string $inTitle S�ngtitel
	*	@param string $inNewSongFileName Filnamn (ogg-ljudet)
	*/
	function insertSong($inDBH, $inArtistId, $inCount, $inTitle, $inNewSongFileName) {
    $args = array(



        'id'=>$inArtistId,
        'count'=>$inCount,
        'title'=>$inTitle,
          'sound'=>$inNewSongFileName,



      );

      $sql = "INSERT INTO tblsong(artistid, count, title, sound) VALUES(:id, :count, :title, :sound);";
            myDBQuery($inDBH, $sql,$args);
    		validateAndMoveUploadedFile("ogg");
	}

	/**
	*	Funktionen updateSong uppdaterar en befinlig s�ng i databasen. Om en ny ogg-fil har angivits tar funktionen bort den gamla och
	*	anropar validateAndMoveUploadedFile() f�r att flytta den nya uppladdade ogg-filen till r�tt underkatalog.
	*	Funktionen returnerar ingen data men kastar ett undantag om n�got gick fel i samband med att den gamla ogg-filen skall tas bort.
	*
	*	@param resurce $inDBH Databaskoppling
	*	@param $inSongId string Prim�rnyckeln f�r s�ngen som skall uppdateras
	*	@param string $inArtistId Fr�mmandenyckeln f�r artisten som knyts mot s�ngen
	*	@param string $inCount Antalet "gilla" (count)
	*	@param string $inNewSongFileName Filnamn p� det nya ogg-ljudet
	*	@param string $inOldSongFileName Filnamn p� det gamla ogg-ljudet
	*/
    function updateSong($inDBH, $inSongId, $inArtistId, $inCount, $inTitle, $inNewSongFileName, $inOldSongFileName) {

      $args = array(
        'idsong'=>$inSongId,
          'id'=>$inArtistId,
            'count'=>$inCount,
              'title'=>$inTitle,
                'sound'=>$inNewSongFileName,
        );
        $sql = "UPDATE tblsong SET title='$inTitle', count='$inCount', artistid='$inArtistId'";
            if( !empty($inNewSongFileName) )
                $sql .= ", sound='$inNewSongFileName' ";

            $sql .= "WHERE id=$inSongId";
            if( !empty($inOldSongFileName) )
              myDBQuery($inDBH, $sql,$args);
            validateAndMoveUploadedFile("ogg");
                unlink($_SERVER["DOCUMENT_ROOT"]."/MusicSite/upload_ogg/".$inOldSongFileName);

		}

	/**
	*	Funktionen deleteSong tar bort en befinlig song fr�n databasen. D�rtill tar funktionen bort den ogg-fil som s�ngen �r knuten mot.
	*	Funktionen returnerar ingen data men kastar ett undantag om n�got gick fel i samband med att ogg-filen skall tas bort.
	*
	*	@param resurce $inDBH Databaskoppling
	*	@param $inSongId string Prim�rnyckeln f�r s�ngen som skall tas bort
	*	@param string $inSongFileName Filnamn p� ogg-ljudet
	*/
    function deleteSong($inDBH, $inSongId, $inSongFileName) {
			$sql="DELETE FROM tblsong WHERE id=:id";
      $args = array(
        'id'=>$inSongId,
      ); // värde
			myDBQuery($inDBH, $sql, $args);
			unlink($_SERVER["DOCUMENT_ROOT"] . "/MusicSite/upload_ogg/" . $inSongFileName);
		}
