<?php
require_once(dirname(dirname(__DIR__)) . '/config.php');

CheckTourSession(true);
checkACL(AclQualification, AclReadWrite);

require_once('Common/Lib/CommonLib.php');


$PAGE_TITLE='bzmExport';
$TourId=$_SESSION['TourId'];

$default_submitter="Frank, Thomas";
$default_club_id="203021";
$default_state="BY";

include('Common/Templates/head.php');

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
