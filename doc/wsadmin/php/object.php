<?php //hier werden objekte definiert
function SendFormButtons($buttons)
{
//function SendResetCancel($change) {

	echo "<input type='submit' name='send' value='Speichern'>\n";
	echo "<input type='reset' name='cancel' value='Zur&uuml;cksetzen'>\n";
	if (in_array("delete", $buttons))
		echo "<input type='button' name='delete' value='Eintrag l&ouml;schen' onclick='entryDelete(titel)'>\n";
	if (in_array("delete_pdf", $buttons))
		echo "<input type='button' name='delete' value='Pdf l&ouml;schen' onclick='pdfDelete(pdfname)'>\n";
	if (in_array("delete_audiofile", $buttons))
		echo "<input type='button' name='delete' value='Audiofile l&ouml;schen' onclick='audiofileDelete(audiofilename)'>\n";
}
function hiddenfields($all){
	if (isset($new) && $new == "true")
		echo '<input type="hidden" name="new" value="true">';
	if (isset($change) && $change == "true")
		echo '<input type="hidden" name="change" value="true">';
}
$bereich_array = array("Familie","Arbeit","Gesundheit","Erziehung","zur Person"); 
?>
