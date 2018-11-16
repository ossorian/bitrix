<?php
class AdmParserDataConverter extends AdmParser
{
	
	public static $sectionIDs = array();
	
	function __construct()
	{
		$result = CIBlock::GetList(array(), array("CODE" => parent::IBLOCK_CODE))->Fetch();
		if ($result["ID"]) $this->iblockID = $result["ID"];
		
	}
	
	public function makeCurrentData()
	{
		$elements = CIBlockElement::GetList(array(), array("IBLOCK_CODE"=>self::IBLOCK_CODE), false, false, array("ID", "NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "ACTVE_DATE_FROM"));
		while ($element = $elements->Fetch()) {
			$this->rawData[] = $element;
		}
		
		$this->makeSortedData();
		unset($this->rawData);
	}
	
	public function checkChanges(&$arCandidates)
	{
		foreach ($arCandidates as $key => $candidate){
			if (!isset($this->data[$candidate['href']])) {
					continue; //to Add
				}
			elseif ($candidate['name'] != $this->data[$candidate['href']]['name'] ||
					$candidate['text'] != $this->data[$candidate['href']]['text'] ){
				$arCandidates[$key]['id'] = $this->data[$candidate['href']]['id']; 	//to Update
			}
			else unset($arCandidates[$key]); //no Deleting, just no action
		}
	}

	public function update($arCandidates)
	{
		if (empty($this->iblockID)) return;
		foreach ($arCandidates as $item) {
			if (isset($item['id'])) $this->updateItem($item);
			else $this->addItem($item);
		}
	}
	
	private function addItem($item)
	{
		$obElement = new CIblockElement();
		$result = $obElement->Add(
			array(
				"IBLOCK_ID" => $this->iblockID,
				"NAME" => $item['name'],
				"PREVIEW_TEXT" => $item['text'],
				"DETAIL_TEXT" => $item['href'],
				"ACTIVE_FROM" => $item['date'], //self::convertDate($item["date"]),
				"IBLOCK_SECTION_ID" => self::getSectionID($item['sectionName'])
			),
			false, true, false
		);
	}
	
	private static function updateItem($item)
	{
		$obElement = new CIblockElement();
		$result = $obElement->Update( $item['id'],
			array(
				"NAME" => $item['name'],
				"PREVIEW_TEXT" => $item['text'],
				"ACTIVE_FROM" => $item['date']//self::convertDate($item["date"])
			),
			false, false, false, false
		);
	}
	
	private static function getSectionID($sectionName)
	{
		if (!empty(self::$sectionIDs[$sectionName])) return self::$sectionIDs[$sectionName];
		
		$section = CIBlockSection::GetList(array(), array("IBLOCK_CODE" => self::IBLOCK_CODE, "CODE" => $sectionName), false, array("ID", "IBLOCK_ID"), array("nTopCount"=>1)) -> Fetch();
		if ($section['ID']) return self::$sectionIDs[$sectionName] = $section['ID'];
		return self::createSection($sectionName);
	}

	private static function createSection($sectionName)
	{
		if (!$iblock = CIBlock::GetList(array(), array("CODE"=>self::IBLOCK_CODE)) -> Fetch() ) return false;
		if (empty($iblock["ID"])) return false;

		$cSection = new CIBlockSection();
		$sectionID = $cSection->Add(
			array(
				"IBLOCK_ID" => $iblock["ID"],
				"NAME" => $sectionName,
				"CODE" => $sectionName,
				"SORT" => 500,
			), true, false
		);
		return self::$sectionIDs[$sectionName] = $sectionID;
	}
	
	private static function convertDate($initialDate)
	{
		return $timestamp = MakeTimeStamp($initialDate, 'DD.MM.YYYY');
	}
	
	private function makeSortedData(){
		if (empty($this->rawData)) return;
		foreach($this->rawData as $datum)
		{
			$this->data[$datum['DETAIL_TEXT']] = array(
				'name' => $datum['NAME'],
				'date' => $datum['DATE_ACTIVE_FROM'],
				'text' => $datum['PREVIEW_TEXT'],
				'id' => $datum['ID']
			);
		}
	}
	
}
?>
