<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!CModule::IncludeModule("highloadblock")) {
	echo "Ошибка подключения модуля HighLoad блоков";
	return;
}
use Bitrix\Highloadblock as HL;
define('USOFT_MAP_HL_NAME', 'UsoftMapHL');
define('USOFT_MAP_HL_TABLE_NAME', 'usoft_map');
$arFields = array('LAT', 'LON');

	//Params
	if (empty($arParams["LON_MAIN"])) $arParams["LON_MAIN"] = "55.753215";
	if (empty($arParams["LAT_MAIN"])) $arParams["LAT_MAIN"] = "37.622504";
	if (empty($arParams["ZOOM_MAIN"])) $arParams["ZOOM_MAIN"] = "10";
?>
<?
try {
	$entity = HL\HighloadBlockTable::compileEntity(USOFT_MAP_HL_NAME);
}
catch(Exception $e) {
	//create new HighLoadBlock
	$result = HL\HighloadBlockTable::add(
		array(
			'NAME' => USOFT_MAP_HL_NAME,
			'TABLE_NAME' => USOFT_MAP_HL_TABLE_NAME,
		)
	);
	if (!$result->isSuccess()) {
		$errors = $result->getErrorMessages();
		foreach ($errors as $error) echo "<p>$error</p>";
	} else {
		//create HL fields
		$entity = HL\HighloadBlockTable::compileEntity(USOFT_MAP_HL_NAME);
		$entityID  = $result->getId();
		$userTypeEntity = new CUserTypeEntity();
		
		foreach ($arFields as $field) {
			$aUserFields    = array(
				'ENTITY_ID' 	=> 'HLBLOCK_'.$entityID,
				'FIELD_NAME'    => usoftGetFieldName($field),
				'USER_TYPE_ID'  => 'string',
				'XML_ID'        => USOFT_MAP_HL_NAME.'_'.$field,
				'SORT'          => 500,
				'MULTIPLE'      => 'N',
				'MANDATORY'     => 'Y',
				'SHOW_FILTER'   => 'N',
				'SHOW_IN_LIST'  => '',
				'EDIT_IN_LIST'  => '',
				'IS_SEARCHABLE' => 'N',
				'SETTINGS' => array(
					'DEFAULT_VALUE' => '',
					'SIZE'          => '20',
					'ROWS'          => '1',
					'MIN_LENGTH'    => '0',
					'MAX_LENGTH'    => '0',
					'REGEXP'        => '',
				),
			);
			$iUserFieldId = $userTypeEntity->Add($aUserFields); // int
		}
	}
}

if (!$entity || !is_object($entity)) {
	echo "Ошибка иницилизации";
	return;
}

//getting Data
$mapClass = $entity->getDataClass();

$result = $mapClass::getList(array(
	'select' => array('*'),
	'order'  => array('ID' => 'ASC'),
));

while($arItem = $result->Fetch()) {
	$arIDs[] = $arItem["ID"];
	$arResult["ITEMS"][] = array(
		"id" => $arItem["ID"],
		"lat" => $arItem["UF_USOFTMAPHL_LAT"],
		"lon" => $arItem["UF_USOFTMAPHL_LON"],
		"changed" => false
	);
}

if (!empty($_POST['ajax']) && $_POST['data']) {
	//Обработка Ajax запросов на сохранение
	$data = json_decode($_POST['data']);
	if (count($data)) {
		$inserted = $deleted = 0;
		foreach ($data as $datum) {
			$arIDchecked[] = $datum['id'];
			
			if ($datum["changed"]) {
				$arCoords = array("UF_USOFTMAPHL_LAT" => $datum['lat'], "UF_USOFTMAPHL_LON" => $datum['lon']);
				//Добавление
				if (array_search($datum['id'], $arIDs) === false) {
					$mapClass::add($arCoords);
					$inserted++;
				}
				//Изменение
				else {
					$mapClass::update($datum['id'], $arCoords);
				}
			}
		}
		
		//Удаление
		$arDeleted = array_diff($arIDs, $arIDchecked);
		if ($arDeleted) {
			foreach ($arDeleted as $id) {
				$mapClass::delete($id);
				$deleted++;
			}
		}
		
		if (($inserted + count($arIDs) - $deleted) == count($data)) $result = 'ok';
		else $result = "Не совпадает количество переданных точек с количеством в БД.";
	}
	else $result = "Неверно переданные данные для сохранения";
	echo $result;
	die;
}
else {
	$this->IncludeComponentTemplate();
}
//to use DRY method!
function usoftGetFieldName($field) {
	return 'UF_'.strtoupper(USOFT_MAP_HL_NAME).'_'.$field;
}
?>