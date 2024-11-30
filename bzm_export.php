<?php
require_once(dirname(dirname(__DIR__)) . '/config.php');

CheckTourSession(true);
checkACL(AclQualification, AclReadWrite);

require_once('Common/Lib/CommonLib.php');

// require_once('mod_func.php');


$PAGE_TITLE='bzmExport';
$TourId=$_SESSION['TourId'];

$default_submitter="Frank, Thomas";
$default_club_id="203021";
$default_state="BY";


//--- Get team classes of the tournament (classes are stored in events)
// $Events = '';
// $q=safe_r_SQL("	SELECT DISTINCT ev.EvEventName as Klasse, ev.EvCode 
// 				FROM ianseo.Individuals i
// 				left join Events ev on (ev.EvTournament = i.IndTournament and i.IndEvent = ev.EvCode)
// 				left join Tournament t on (i.IndTournament = t.ToId)
// 				where i.IndTournament = {$_SESSION['TourId']}
// 				and ev.EvTeamEvent = 0 
// 				order by IndEvent, EvProgr");
// while($r=safe_fetch($q)) {
// 	$Events .= '<div><input type="checkbox" id="'.$r->EvCode.'" name="EvCode[]" value="'.$r->EvCode.'"  checked /><label for="'.$r->EvCode.'">'.$r->Klasse.'</label></div>';
// }

// $IncludeJquery = true;
include('Common/Templates/head.php');

//--- Get team classes of the tournament (classes are stored in events)
// $q_preview=safe_r_SQL("SET @row_number = NULL;");
// $q_preview=safe_r_SQL("SELECT  t.ToName as Turnier,
// 						DATE_FORMAT(t.ToWhenFrom, '%d.%m.%Y') as Datum ,
// 						co.CoName as Verein,
// 						ev.EvEventName as Klasse,
// 						q.QuScore as Ringe,
// 						q.QuClRank as Rang,
// 						c.ClDescription as Klassenbeschreibung,
// 						d.DivDescription as Division,
// 						e.EnFirstName as FirstName,
// 						e.EnName as Name
// 						FROM ianseo.Individuals i
// 						left join Qualifications q on i.IndId = q.QuId
// 						left join Events ev on (ev.EvTournament = i.IndTournament and ev.EvCode = i.IndEvent)
// 						left join Entries e on (e.EnId = i.IndId and e.EnTournament = i.IndTournament)
// 						left join Countries co on (i.IndTournament = co.CoTournament and e.EnCountry = co.CoId)
// 						left join Tournament t on (i.IndTournament = t.ToId)
// 						left join Classes c on (e.EnTournament = c.ClTournament and e.EnClass = c.ClId)
// 						left join Divisions d on (d.DivTournament = e.EnTournament and e.EnDivision = d.DivId)
// 						where i.IndTournament = $TourId
// 						and q.QuScore > 0
// 						and q.QuClRank <= 3
// 						and ev.EvTeamEvent = 0
// 						order by ev.EvEventName, q.QuClRank
// 			   			limit 12");

?>

<form action="bzm_export_action.php" method="post" target="_self" class="smallForm">
	<label for="submitter">Submitter:</label>
    <br>
    <input name="submitter" id="submitter" value="<?php echo $default_submitter ?>">
    <br>
    <label for="club_id">Club ID:</label>
    <br>
    <input name="club_id" id="club_id" value="<?php echo $default_club_id ?>">
    <br>
    <label for="state">Federal State:</label>
    <br>
    <input name="state" id="state" value="<?php echo $default_state ?>">
    <br>
    <input type="submit" value="export">
</form>

<?php
	include('Common/Templates/tail.php');
?>
