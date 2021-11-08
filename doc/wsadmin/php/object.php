<?php //hier werden objekte definiert
function SendFormButtons($buttons)
{
//function SendResetCancel($change) {

	echo "<input type='submit' name='send' value='Speichern'>\n";
	echo "<input type='reset' name='cancel' value='Zur&uuml;cksetzen'>\n";
	if (in_array("delete", $buttons))
		echo "<input type='button' name='delete' value='Eintrag l&ouml;schen' onclick='entryDelete()'>\n";
	if (in_array("delete_pdf", $buttons))
		echo "<input type='button' name='delete' value='Pdf l&ouml;schen' onclick='pdfDelete()'>\n";
	if (in_array("delete_audiofile", $buttons))
		echo "<input type='button' name='delete' value='Audiofile l&ouml;schen' onclick='audiofileDelete()'>\n";
}
function hiddenfields($all){
	if (isset($new) && $new == "true")
		echo '<input type="hidden" name="new" value="true">';
	if (isset($change) && $change == "true")
		echo '<input type="hidden" name="change" value="true">';
}
$bereich_array = array("Familie","Arbeit","Gesundheit","Erziehung","zur Person"); 
?>
<script>
function entryDelete() {
	if (confirm('Wollen Sie den Eintrag wirklich löschen?')) {
		document.getElementsByName('entrydelete')[0].submit();
	}
}
function pdfDelete() {
	if (confirm('Wollen Sie diese Pdf Datei wirklich löschen?')) {
		document.getElementsByName('pdfdelete')[0].submit();
	}
}
function audiofileDelete() {
	if (confirm('Wollen Sie diese Audio Datei wirklich löschen?')) {
		document.getElementsByName('audiofiledelete')[0].submit();
	}
}
</script>
