<?php
if (!is_array($arParams["DISTANT_URLS"]) || empty($arParams["DISTANT_URLS"])) return;

$debug = ($arParams["IS_DEBUG"] == "Y");
if ($debug){
	error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
	ini_set('display_errors', 1);
	$time = microtime();
}

include('AdmParser.php');
include('AdmParserDataConverter.php');
if (!AdmParser::checkIblock()) return;

if (!$arCandidates = AdmParser::getCandidates($arParams["DISTANT_URLS"])) return false;

$cConverter = new AdmParserDataConverter();

$cConverter->makeCurrentData();
$cConverter->checkChanges($arCandidates);
$cConverter->update($arCandidates);
if ($debug) echo microtime() - $time;