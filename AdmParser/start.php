<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
?><?
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
ini_set('display_errors', 1);
include('AdmParser.php');
include('AdmParserDataConverter.php');

//setToParameters
$arUri = array(
	"https://dms.khabarovskadm.ru/privatization/prodazha-munitsipalnogo-imushchestva-bez-obyavleniya-tseny/",
//	"https://dms.khabarovskadm.ru/mo/inform/public/",
	"https://dms.khabarovskadm.ru/mo/inform/konkurs/",
//	"https://dms.khabarovskadm.ru/mo/inform/auction/"
);
$time = microtime();

if (!AdmParser::checkIblock()) return;

$arCandidates = AdmParser::getCandidates($arUri);


$cConverter = new AdmParserDataConverter();
$cConverter->makeCurrentData();
$cConverter->checkChanges($arCandidates);
var_dump($arCandidates);
$cConverter->update($arCandidates);


echo microtime() - $time;
//var_dump($arCandidates);
?><?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>