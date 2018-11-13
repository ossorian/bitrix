<?php
foreach ($arResult["ITEMS"] as &$item) {
	$item["DETAIL_PAGE_URL"] = $item["~DETAIL_TEXT"];
	//var_dump($item);
}

include('parse.php');