<?php
/* Version 1.01 Changes:
* Putting different url data to specific folder to show them later differently in AdmParser.php
* Encoding changes precisely to SITE_CHARSET constant in AdmParser.php
* Using $arParams["IS_PARSE"] parameter to switxch it off just fow rendering, not parsing. Necessary for using the parser in some folders together.
*/

/* Starting conditions */
if ($arParams["IS_PARSE"] == "Y") return;
if (!is_array($arParams["DISTANT_URLS"]) || empty($arParams["DISTANT_URLS"])) return;

$debug = ($arParams["IS_DEBUG"] == "Y");
if ($debug){
	error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
	ini_set('display_errors', 1);
	$time = microtime();
}


return;

/* Body */

include('AdmParser.php');
include('AdmParserDataConverter.php');
if (!AdmParser::checkIblock()) return;

if (!$arCandidates = AdmParser::getCandidates($arParams["DISTANT_URLS"])) return false;

$cConverter = new AdmParserDataConverter();

$cConverter->makeCurrentData();
$cConverter->checkChanges($arCandidates);
$cConverter->update($arCandidates);
if ($debug) echo microtime() - $time;