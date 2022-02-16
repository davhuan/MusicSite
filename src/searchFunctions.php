<?php
	/* Funktioner (inklusive parametrar) som behövs för att hantera söksidan */

	/**
	*	Funktionen printSearchForm() skriver ut formuläret (frmsearch) i vilket det går att skriva in en artist och/eller låt att söka på.
	*	Funktionen tar inte emot någon data och returnerar heller någon data.
	*
	*/
    function printSearchForm() {
//skriver ut formuläret
			echo('<h1>Search Artist and/or Song!</h1>
							<hr />

							<form action="search.php" method="post" name="frmsearch">
								<fieldset>
									<legend>
										Song and/or Artist
									</legend>
									<input type="text" id="txtsearch" name="txtSearch" title="Song and/or Artist!" required="required" placeholder="Type Artist or Song and press Search!" size="35" autofocus="autofocus"/><br />
									<input type="submit" id="btnsearch" name="btnSearch" value="Search" />
									<input type="reset" id="btnreset" name="btnReset" value="Reset" />
								</fieldset>
							</form>');

		}



	/**
	*	Funktionen listArtists söker ut samtliga artister som matchar sökkriteriet och skriver ut dessa som de visas i laboration 1.
	*	Matchas inga inga poster mot sökkriteriet skriver funktionen ut "Inga artister matchar din sökning!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBH Databaskoppling
	*	@param string $inSearchString Söksträngen
	*/
	function listArtists($inDBH, $inSearchString) {
		$sql="SELECT * FROM tblartist WHERE name LIKE '%" . $inSearchString . "%'";//skapar en sql query som skall skickas till databasen
      $args= array();
		  foreach(myDBQuery($inDBH, $sql,$args) as $row){//för varje värde i arrayen som returneras av databasen som kommer loopas , foreach fungerar som en loop.
echo('<fieldset><legend>Searchresult Artist</legend>');
		echo('Name: ' . $row['name'] . ' <br /><a href="upload_jpg/' . $row['picture'] . '" rel="lightbox"><img src="upload_jpg/' . $row['picture'] . '"  alt="' . $row['picture'] . '" /></a><br />');

		}
		echo('</fieldset><br />');
	}


	/**
	*	Funktionen listSongs söker ut samtliga sånger som matchar sökkriteriet och skriver ut dessa som de visas i laboration 1.
	*	För varje matching anropas också funktionerna listComments() och printCommentForm().
	*	Matchas inga inga poster mot sökkriteriet skriver funktionen ut "Inga sånger matchar din sökning!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBH Databaskoppling
	*	@param string $inSearchString Söksträngen
	*/
	function listSongs($inDBH, $inSearchString) {
		$sql="SELECT * FROM tblsong WHERE title LIKE '%" . $inSearchString . "%'";//skapar sql fråga

		echo("<fieldset><legend>Searchresult Song</legend>");
		$args= array(
     // 'search'=>$inSearchString,
    );
		foreach(myDBQuery($inDBH, $sql,$args) as $row){
			listComments($inDBH, $row['id']);//listar kommentarer
			printCommentForm($row['id'], $row['title']);//skriver ut kommentars formuläret

			echo('
      <a href="#" data-id="' . $row['id'] . '">Like ' . $row['sound'] . '</a><p>Title: ' . $row['title'] . '<br />Song: ' . $row['sound'] . '<br />Count: <span data-id="' . $row['id'] . '">' . $row['count'] . '</span><br />
      <audio controls="controls"><source src="upload_ogg/' . $row['sound'] . '" />
       Din webbläsare stödjer inte audio-taggen!</audio><br />  </p><hr />');

		}
		echo("</fieldset>");
	}


    /**
	*	Funktionen listComments söker ut samtliga kommentarer som matchar inkommande $inSongId och skriver ut dessa som de visas i laboration 1.
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBH Databaskoppling
	*	@param string $inSongId Primärnyckeln för den sång som det skall listas kommentarer för.
	*/
	function listComments($inDBH, $inSongId){
		$sql="SELECT * FROM tblcomment WHERE songid=:songid ORDER BY id DESC";//skapar ett sql fråga
		echo('<div data-comments="comments" data-id="' . $inSongId . '">');
    $args = array(
   // 'songid' => $inSongId,
    );    
   foreach(myDBQuery($inDBH, $sql, $inSongId,$args) as $row){


			$date=date('Y-m-d H:i', strtotime($row['insertdate'])); //Hämtar datum, tid
			echo('<p><b>' . $date . ' :</b><i>' . $row['text'] . '</i></p>'); //skriver ut datum, tid, kommentar info
		}
		echo('</div>');
	}

	/**
	*	Funktionen printCommentForm() skriver ut formuläret (frmcomment) i vilket det går att skriva in en kommentar för en låt.
	*	Funktionen returnerar ingen data.
	*
	*	@param string $songId Primärnyckeln för den låt som kommentarsfältet skall knytas mot
	*	@param string $inSongFileName låtnamnet för den låt som kommentarsfältet skall knytas mot
	*/
	function printCommentForm($songId, $inSongFileName) {
		echo('<form action="#" method="post" name="frmcomment" data-id="' . $songId . '">
								<fieldset>
									<legend>
										Comment on ' . $inSongFileName . '
									</legend>
									<textarea name="txtComment" cols="40" rows="10" title="Comment" required="required" placeholder="Write your comment!"></textarea><br />
									<input type="hidden" name="hidId" value="' . $songId . '" />
									<input type="submit" name="btnSave" value="Save" />
									<input type="reset" name="btnReset" value="Reset" />
								</fieldset>
							</form>');
	}
