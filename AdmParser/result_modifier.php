<?php
foreach ($arResult["ITEMS"] as &$item) {
	$item["DETAIL_PAGE_URL"] = $item["~DETAIL_TEXT"];
	if (($len = strlen($item["NAME"])) == 255 && $item["NAME"]{$len - 1} != ' ' )
		$item["NAME"] .= "...";
}

include('parse.php');