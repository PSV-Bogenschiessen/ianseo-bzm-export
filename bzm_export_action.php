<?php

require_once(dirname(dirname(__DIR__)) . '/config.php');
CheckTourSession(true);
checkACL(AclQualification, AclReadWrite);

require_once('Common/Lib/CommonLib.php');
require_once('Common/tcpdf/tcpdf.php');

$PAGE_TITLE='individualCertificates';
$TourId=$_SESSION['TourId'];
// --- be sure all received post infos are harmless
$args = array(
    'submitter' => FILTER_SANITIZE_ENCODED,
    'club_id' => FILTER_SANITIZE_ENCODED,
    'state' => FILTER_SANITIZE_ENCODED,
);

$pageInputs = filter_input_array(INPUT_POST, $args);

$Submitter = $pageInputs["submitter"];
$Submitter = urldecode($Submitter);
$ClubId = $pageInputs["club_id"];
$ClubId = urldecode($ClubId);
$State = $pageInputs["state"];
$State = urldecode($State);

$query = <<<SQL
SELECT  
  e.EnFirstName as Name,
  e.EnName as Vorname,
  "$Submitter" as Melder,
  co.CoName as Verein,
  "$ClubId" as "Vereinsnr.",
  "$State" as Land,
  e.EnCode as PassNummer,
  q.QuScore as "Ergeb. VM",
  CASE
    WHEN e.EnSex = 0 THEN 'm'
    WHEN e.EnSex = 1 THEN 'w'
    ELSE e.EnSex
  END AS "m/w",
  CASE
    WHEN e.EnDivision = 'R' THEN 'rec'
    WHEN e.EnDivision = 'B' THEN 'blank'
    WHEN e.EnDivision = 'C' THEN 'comp'
    ELSE e.EnDivision
  END AS Bogenart,
  DAY(e.EnDob) AS "Geb. Tag",
  MONTH(e.EnDob) AS "Geb. Monat",
  YEAR(e.EnDob) AS "Jahrg.",
  SUBSTRING(e.EnClass FROM 2) AS "Klasse Nr.",
  "" AS "Änd. Klasse",
  "" AS "Startnr.",
  "" AS "Zähler",
  "" AS "Start- geld",
  "" AS "Mannsch. Nummer",
  CONCAT(e.EnFirstName, ', ', e.EnName) AS NameT,
  "BZMWA7202016" AS "Veranstaltungstitel",
  "ja" AS "Meldung Schütze",
  CONCAT(e.EnDob, "T00:00:00") AS "Geb_datumT"
FROM ianseo.Entries e
left join Qualifications q on e.EnId = q.QuId
left join Countries co on (e.EnTournament = co.CoTournament and e.EnCountry = co.CoId)
where e.EnTournament = $TourId
and q.QuScore > 0
ORDER BY CAST(SUBSTRING(e.EnClass FROM 2) AS UNSIGNED), q.QuScore DESC
SQL;

$q = safe_r_SQL($query);
$r = safe_fetch($q);

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="output.csv"');
header('Cache-Control: no-store, no-cache, must-revalidate');


$output = fopen('php://output', 'w');
$headers = array_keys( (array) $r);
fputcsv($output, $headers);

do {
    fputcsv($output, (array) $r);
} while ($r=safe_fetch($q));

fclose($output);
?>
