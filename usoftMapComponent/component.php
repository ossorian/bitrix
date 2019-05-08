<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!CModule::IncludeModule("highloadblock")) {
	echo "Ошибка подключения модуля";
	return;
} 
use Bitrix\Highloadblock as HL;
define('USOFT_MAP_HL_NAME', 'UsoftMapHL');
define('USOFT_MAP_HL_TABLE_NAME', 'usoft_map');
$arFields = array('LAT', 'LON');
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
$selectFields = array("ID");
foreach ($arFields as $field) {
	$selectFields[] = usoftGetFieldName($field);
}
$result = $mapClass::getList(array(
	'select' => $selectFields,
	'order'  => array('ID' => 'ASC'),
));

while($arItem = $result->Fetch()) {
	$arResult["ITEMS"][] = $arItem;
}
$this->IncludeComponentTemplate();

//to use DRY method!
function usoftGetFieldName($field) {
	return 'UF_'.strtoupper(USOFT_MAP_HL_NAME).'_'.$field;
}
?>