<?php
/** README FIRST!
- To get other urls from other resources you just need to make some more candidates with the same structure:
$arCandidates[] = array("href", "name", "text")
- As the date format may differ from website to website, you should insert it as a string in text field
- No date fields included into the Iblock because of the same reason and in order not to make special property fields
 */
class AdmParser
{
	
	const IBLOCK_CODE = 'estate_parse1';
	const IBLOCK_TYPE_CODE = 'parsers';
	
	public static function getCandidates($arUri = array())
	{
		libxml_use_internal_errors(true);
		foreach ($arUri as $uri){
			
			$domain = self::getDomain($uri);
			$doc = new DOMDocument();
			if (!$doc->loadHTMLFile($uri)) self::showError(1, $uri);

			$xpath = new DOMXPath($doc);
			$items = $xpath->query('//div[@class="contentwr"]/div[@class="news-list"]/p[@class="news-item"]');
			foreach ($items as $i => $item) {
			
				if ($font = $item->getElementsByTagName('font')[0])
					$date = iconv('UTF8', 'CP1251', $font->nodeValue);
				elseif ($span = $item->getElementsByTagName('span')[0])
					$date = iconv('UTF8', 'CP1251', $span->nodeValue);
				
				if ($a = $item->getElementsByTagName('a')[0]) {
					$name = trim(iconv('UTF8', 'CP1251', $a->nodeValue));
					$href = $a->getAttribute('href');
				}

				$text = trim(str_replace(array($date, $name), '', iconv('UTF8', 'CP1251', $item->nodeValue)));
				
				
				if ($name && $href){
					$arCandidates[] = array(
						"href" => (strpos($domain, $href) === false) ? $domain.$href : $href,
						"name" => $name,
						"text" => $text,
						"date" => $date
						
					);
				}
			}
			if (is_null($i)) self::showError(2, $uri);
		}
		return $arCandidates;
	}
	
	public static function checkIblock()
	{
		if ($isBlock = CIBlock::GetList(array(), array("CODE"=>self::IBLOCK_CODE)) -> Fetch()) return true;
		if (!self::checkIblockType()) {
			return false;
		}
		
		$arFields = array(
			"LID" => 's1',
			"CODE" => self::IBLOCK_CODE,
			"IBLOCK_TYPE_ID" => self::IBLOCK_TYPE_CODE,
			"NAME" => GetMessage("PARSER_IBLOCK_NAME"),
			"SORT" => 1000,
			"WORKFLOW" => "N",
			"VERSION" => 2,
			"INDEX_ELEMENT" => "N",
			"RSS_ACTIVE" => "N"
		);
		
		global $DB;
		$DB->StartTransaction();
		$obIblock = new CIBlock();
		
 		$result = $obIblock->Add($arFields);
		if (!$result) {
			$DB->Rollback();
			self::showError(4);
			echo 'Error: '.$obIblock->LAST_ERROR.'<br>';
		}
		else {
			$DB->Commit();
		}
		return $result;
	}
	
	private static function getDomain($uri)
	{
		$url = parse_url($uri);
		return $url['scheme'].'://'.$url['host'];
	}
	
	private static function checkIblockType()
	{
		if (CIBlockType::GetList(array(), array("ID" => self::IBLOCK_TYPE_CODE))->Fetch()) return true;
		
		$arFields = array(
			'ID'=>self::IBLOCK_TYPE_CODE,
			'SECTIONS'=>'N',
			'IN_RSS'=>'N',
			'SORT'=>1000,
			'LANG'=>Array(
				'en'=>Array(
					'NAME'=>'Parsers',
					'SECTION_NAME'=>'None',
					'ELEMENT_NAME'=>'Distant information'
				),
				'ru'=>Array(
					'NAME'=>'Парсеры',
					'SECTION_NAME'=>'Отсутствует',
					'ELEMENT_NAME'=>'Блок информации'
				)
			)
		);
		
		$obIblockType = new CIBlockType();
		global $DB;
		$DB->StartTransaction();
		$result = $obIblockType->Add($arFields);
		
		if (!$result) {
			$DB->Rollback();
			self::showError(3);
			echo 'Error: '.$obIblockType->LAST_ERROR.'<br>';
		}
		else {
			$DB->Commit();
		}
		return $result;
	}
	
	private static function showError($number, $uri = false)
	{
		$error = array(
			1 => "Не удаётся загрузить страницу $uri для предоставления информации. Пожалуйста исправьте настройки компонента",
			2 => "Не удалось найти элементы для отображения на странице $uri. Изменился шаблон компонента.",
			3 => "Не удалось создать новый тип инфоблока",
			4 => "Не удалось создать инфоблок для храения информации"
		);
		echo '<font color="red">'.$error[$number].'</font><br>';
	}
	
	
}
