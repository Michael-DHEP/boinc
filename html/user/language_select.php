<?php
require_once("../inc/util.inc");
require_once("../inc/translation.inc");
$imgdir = "img/flags/";


$languages = getSupportedLanguages();

if (get_str("set_lang")){
    if (!in_array(get_str("set_lang"), $languages) && get_str("set_lang")!="auto"){
	echo "You must select a supported language";
	exit;
    } else {
	setcookie('lang', get_str("set_lang"), time()+3600*24*365);
	header("Location: language_select.php");
	flush();
	exit;
    }
}

page_head("Language selection");

echo "
    <p>This website may be displayed to you in one of the following languages. Usually the server will automatically determine
    which language you use but you can override this by clicking on one of the links. Clicking a link will send you a cookie which
    stores your language selection on your computer (if you experience any problems please check that your browser accepts 
    cookies from our domain).</p>";
echo "<p>The currently selected language is: <em>".tr(LANG_NAME_INTERNATIONAL)."</em> (".tr(LANG_NAME_NATIVE).")</p>";



start_table();
for ($i=0; $i<sizeof($languages);$i++){
    $lang_native[$i] = trSpecific(LANG_NAME_NATIVE,$languages[$i]);
    $lang_international[$i] = trSpecific(LANG_NAME_INTERNATIONAL, $languages[$i]);
}

array_multisort($lang_international, $languages, $lang_native);

for ($i=0; $i<sizeof($languages);$i++){
    if (file_exists($imgdir.$languages[$i].".png")){
	$im = "<a href=\"language_select.php?set_lang=".$languages[$i]."\"><img height=\"12\" width=\"16\" src=\"".$imgdir.$languages[$i].".png\" border=0></a>";
    } else {
	$im="";
    }
    row3($im,
	"<a href=\"language_select.php?set_lang=".$languages[$i]."\">".$languages[$i]."</a>",
	"<a href=\"language_select.php?set_lang=".$languages[$i]."\">".$lang_international[$i]." (".$lang_native[$i].")</a>");
}
end_table();
echo "<p>You can always go back to automatic language selection by pressing <a href=\"language_select.php?set_lang=auto\">this link</a></p>";
page_tail();
?>
