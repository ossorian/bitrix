<?php
/** README FIRST!

- To get other urls from other resources you just need to make some more candidates with the same structure:
$arCandidates[] = array("href", "name", "text", "date") and with the same encoding;

- The date format is strict not due to change on the distant site! If you want modify it you can try in getCandidates method, but don't forget the date just replaced in "text" as ther is now html tag to get text;

Version 1.01 Changes:
* Putting different url data to specific folder to show them later differently
* Encoding changes precisely to SITE_CHARSET constant
* One can add "sectionName" to $arCandidates to put it in proper sectionID in future

 */
class AdmParser
{

	const IBLOCK_CODE = 'estate_parse1';
	const IBLOCK_TYPE_CODE = 'parsers';
	private static $sectionNames = array();

	public static function getCandidates($arUri = array(), $parseParams = array())
	{
		libxml_use_internal_errors(true);
		foreach ($arUri as $uri){
			if (empty($uri)) continue;
			$domain = self::getDomain($uri);
			$doc = new DOMDocument();
			if (!$doc->loadHTMLFile($uri)) {self::showError(1, $uri);continue;}

			$xpath = new DOMXPath($doc);
			$items = $xpath->query('//div[@class="contentwr"]/div[@class="news-list"]/p[@class="news-item"]');//This mask may change!
			foreach ($items as $i => $item) {

				if ($font = $item->getElementsByTagName('font')[0])
					$date = self::convertText($font->nodeValue);
				elseif ($span = $item->getElementsByTagName('span')[0])
					$date = self::convertText($span->nodeValue);

				if ($a = $item->getElementsByTagName('a')[0]) {
					$name = trim(self::convertText($a->nodeValue));
					$href = $a->getAttribute('href');
				}

				$text = trim(str_replace(array($date, $name), '', self::convertText($item->nodeValue)));
				$text = strip_tags($text);
				if (intval($text)) $text =''; 
				
				if ($name && $href){
					$arCandidates[] = array(
						"href" => (strpos($domain, $href) === false) ? $domain.'/'.$href : $href,
						"name" => $name,
						"text" => $text,
						"date" => $date,
						"sectionName" => $parseParams["PARSE_TO_SECTIONS"] ? self::getSectionName($uri) : NULL
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
			"NAME" => self::convertText('Автоматическая информация о конкурсах и аукционах'),
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

	private static function convertText($text)
	{
		if (SITE_CHARSET == 'windows-1251') return iconv('UTF8', 'CP1251', $text);
		else return $text;//utf-8 e.t.c.
	}

	private static function getDomain($uri)
	{
		$url = parse_url($uri);
		return $url['scheme'].'://'.$url['host'];
	}
	
	private static function getSectionName($uri)
	{
		if (!empty(self::$sectionNames[$uri])) return self::$sectionNames[$uri];
		$url = parse_url($uri);
		$sectionName = trim(str_replace('/', '-', $url['path']), ' -');
		return self::$sectionNames[$uri] = $sectionName;
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
					'NAME'=>self::convertText('Парсеры'),
					'SECTION_NAME'=>self::convertText('Отсутствует'),
					'ELEMENT_NAME'=>self::convertText('Блок информации')
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
			2 => "Не удалось найти элементы для отображения на странице $uri. Изменился шаблон компонента или неверное передан URL страницы.",
			3 => "Не удалось создать новый тип инфоблока",
			4 => "Не удалось создать инфоблок для хранения информации"
		);
		echo '<font color="red">'.str_replace('$uri', $uri, slef::convertText($error[$number])).'</font><br>';
	}
	
	
}
