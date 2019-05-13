<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
        'CACHE_TIME' => array('DEFAULT' => 120),
		
		"LAT_MAIN" => array(
			"NAME" => "Широта центра карты",
			"DEFAULT" => "37.622504",
			"TYPE" => "STRING"
		),
		
		"LON_MAIN" => array(
			"NAME" => "Долгота центра карты",
			"DEFAULT" => "55.753215",
			"TYPE" => "STRING"
		),
		
		"ZOOM_MAIN" => array(
			"NAME" => "Масштаб карты по-умолчанию",
			"DEFAULT" => 10,
			"TYPE" => "STRING"
		),
		
		"YANDEX_API_KEY" => array(
			"NAME" => "Ключ API Яндекс-карт",
			"TYPE" => "STRING",
			"DEFAULT" => ""
		),

		"WIDTH_MAIN" => array(
			"NAME" => "Ширина блока карты",
			"DEFAULT" => "100%",
			"TYPE" => "STRING"
		),

		"HEIGHT_MAIN" => array(
			"NAME" => "Высота блока карты",
			"DEFAULT" => "400px",
			"TYPE" => "STRING"
		),

	),
);
?>