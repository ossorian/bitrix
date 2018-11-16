<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_NAME" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PREVIEW_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISTANT_URLS" => Array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("DISTANT_URLS"),
		"TYPE" => "STRING",
		"MULTIPLE" => "Y"
	),
	"PARSE_TO_SECTIONS" => Array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("PARSE_TO_SECTIONS"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N"
	),
	"IS_DEBUG" => Array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("IS_DEBUG_ON"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N"
	),
	"IS_PARSER_OFF" => Array(
		"PARENT" => "BASE",
		"NAME" => GetMessage("IS_PARSER_OFF"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N"
	)
);

?>
