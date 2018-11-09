<?php
if ($debug = true){
	error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
	ini_set('display_errors', 1);
	$time = microtime();
}

include('AdmParser.php');
include('AdmParserDataConverter.php');

//move it to Parameters!!!
$arUri = array(
	"https://dms.khabarovskadm.ru/privatization/prodazha-munitsipalnogo-imushchestva-bez-obyavleniya-tseny/",
	"https://dms.khabarovskadm.ru/mo/inform/public/",
	"https://dms.khabarovskadm.ru/mo/inform/konkurs/",
	"https://dms.khabarovskadm.ru/mo/inform/auction/"
);

if (!AdmParser::checkIblock()) return;
if (!$arCandidates = AdmParser::getCandidates($arUri)) return false;

$cConverter = new AdmParserDataConverter();

$cConverter->makeCurrentData();
$cConverter->checkChanges($arCandidates);
//var_dump($arCandidates);
$cConverter->update($arCandidates);

if ($debug) echo microtime() - $time;