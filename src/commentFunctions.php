<?php

	/* Funktioner (inklusive parametrar) som beh�vs f�r att administrera kommentarer */

	/**
	*	Funktionen listComments s�ker ut samtliga kommentarer som finns lagrade i databasen och skriver ut dessa som egna formul�r (frmComment).
	*	Finns inga poster lagrade skriver funktionen ist�llet ut "Det finns inga kommentarer i databasen!".
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBH Databaskoppling
	*/

    function listComments($ininDBH){

			$sql = "SELECT * FROM tblcomment";
				$args = array();
			$table = myDBQuery($ininDBH,$sql,$args); // Måste skicka parametrar i rätt ordning, annars tror databasen att "denna frågan kör först"
                echo('<h1>Admin Comment</h1><hr />');
				foreach ($table as $row) {
?>				
					<form action='adminComment.php' method='post' name='frmComment'>
                       
						<p>id:<?php echo htmlspecialchars ($row['id']); ?> <br />
						<p>songid: <?php echo htmlspecialchars ($row['songid']);?><br />
						<p>text: <?php echo htmlspecialchars ($row['text']); ?><br />
						<p>insertdate: <?php echo htmlspecialchars ($row['insertdate']); ?><br />
						<input type='hidden' name='hidId' value=' <?php echo htmlspecialchars($row['id']);?> ' />
						<input type='hidden' name='hidText' value='<?php echo htmlspecialchars($row['text']); ?>' />
						<input type='submit' name='btnDelete' value='Delete' />

					</form>

				<?php
				// htmlspecialchars ska med så man inte kan hacka " ändra värdet "
				}
						}

	/**
	*	Funktionen deleteComment tar bort en befinlig kommentar fr�n databasen.
	*	Funktionen returnerar ingen data.
	*
	*	@param resurce $inDBH Databaskoppling
	*	@param $inCommentId string Prim�rnyckeln f�r kommentaren som skall tas bort
	*/
	function deleteComment($ininDBH, $inCommentId) {
		$sql = "DELETE FROM tblcomment WHERE id=:id";
			$args = array(
				'id'=> $inCommentId,
			); // värde
		$table = myDBQuery($ininDBH,$sql,$args);
		//räknestugan 3
	}
