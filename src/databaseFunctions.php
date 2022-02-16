<?php
/**
 * Funktionen myinDBHConnect kopplar upp webbapplikationen mot MySQL (MariainDBH) med angivna konstanter.
 * Om uppkopplingen misslyckas kastas ett undantag. Om allt fungerar returneras databaskopplingen.
 *
 * @return resource Kopplingen till MySQL mot given databas.
 */
function myDBConnect() {
  define("DB_HOST", "localhost");
  define("DB_USERNAME", "mysqluser");
  define("DB_PASSWORD", "mysqlpassword");
  define("DB", "ISGB24");
  define("CHARSET", "utf8");

  return new PDO(
    'mysql:host=' . DB_HOST . ';dbname=' . DB . ';charset=' . CHARSET, DB_USERNAME, DB_PASSWORD,
    array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    )
  );
}

/**
 * Funktionen myinDBHinQuery exekverar en SQL fråga mot en given databas.
 * Om SQL frågan misslyckas kastas ett undantag. Om allt fungerar returneras en tabell (SELECT) med efterfrågad data
 * eller antalet påverkade rader (INSERT, UPDATE, DELETE).
 *
 * @param resurce $inDBH Databaskoppling
 * @param string $inQuery SQL frågan i klartext
 * @param array $inArgs Parametrar till SQL-frågan
 * @return mixed Array (vektor) med utsökt data (SELECT). Om frågan inte är av en typ
 *         som returnerar data (INSERT, UPDATE och DELETE), returneras
 *         istället antalet påverkade rader (d.v.s. antalet rader som lades
 *         till, uppdaterades eller togs bort).
 */
function myDBQuery($inDBH, $inQuery, $inArgs) {

	try {
		$inDBH->beginTransaction();

		$stmt = $inDBH->prepare($inQuery);
		$stmt->execute($inArgs);

		if ( $stmt->columnCount() > 0 ) {
			$result = $stmt->fetchAll();
		} else {
			$result = $stmt->rowCount();
		}

		$inDBH->commit();
		return $result;

	} catch (PDOException $e) {
		$inDBH->rollBack();
		throw $e;
	}
}

/**
 * Funktionen debugPrint dumpar (skriver ut) innehållet i $inDataToPrint.
 *
 * @param array $inDataToPrint inkommande vektor (matris) som skall dumpas (skrivas) ut.
 * Funtionen returnerar inget!
 */
function debugPrint($inDataToPrint) {
		echo("<pre>" . PHP_EOL);
		print_r($inDataToPrint);
		echo("</pre>". PHP_EOL);
}

/**
 * Funktionen debugPrintAsTable skriver ut innehållet i $inDataToPrint som en HTML5 tabell.
 *
 * @param array $inDataToPrint inkommande vektor (matris) som skall skrivas ut.
 * Funtionen returnerar inget!
 */
function debugPrintAsTable($inDataToPrint) {

	echo("<p>Antalet poster är: " . count($inDataToPrint) . "</p>");

	if(count($inDataToPrint) !== 0) {

		echo(PHP_EOL . "<table>" . PHP_EOL);

		//Tabellhuvud
		echo("<thead>" . PHP_EOL . "<tr>" . PHP_EOL);
		$keys = array_keys($inDataToPrint[0]);
		foreach($keys as $key) {
			echo("<th>" . $key . "</th>" . PHP_EOL);
		}
		echo("</tr>" . PHP_EOL . "</thead>" . PHP_EOL . "<tbody>" . PHP_EOL);

		//Tabellkropp
		foreach($inDataToPrint as $record) {

			echo("<tr>" . PHP_EOL);
			foreach($record as $data) {
				echo("<td>" . $data . "</td>" . PHP_EOL);
			}
			echo("</tr>" . PHP_EOL);
		}

		echo("</tbody>" . PHP_EOL . "</table>" . PHP_EOL);
	}
}
