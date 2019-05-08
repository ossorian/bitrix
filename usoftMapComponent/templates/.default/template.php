<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->addExternalJS('https://api-maps.yandex.ru/2.1/?lang=ru_RU');?>
<div id="map" style="width: 600px; height: 400px"></div>
<script>
	ymaps.ready(usoftMapInit);
	var usoftMap;
	
<?if ($arResult["ITEMS"]):?>
	var placemarks = <?=CUtil::PhpToJSObject($arResult["ITEMS"]);?>;
<?endif?>
</script>