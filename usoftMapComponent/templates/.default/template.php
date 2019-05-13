<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->addExternalJS(
	'https://api-maps.yandex.ru/2.1/?lang=ru_RU'.
	(empty($arParams["YANDEX_API_KEY"]) ? "" : "&amp;apikey=".$arParams["YANDEX_API_KEY"])
);?>
<div id="usoftMap">
	<div id="map" style="width: <?=$arParams["WIDTH_MAIN"]?>; height: <?=$arParams["HEIGHT_MAIN"]?>"></div>
	<div id="usoftMapControls" class="controlPannel">
		<input type="text" name="lon" placeholder="<?=$arParams["LON_MAIN"]?>">
		<input type="text" name="lat" placeholder="<?=$arParams["LAT_MAIN"]?>">
		<input id="usoftMapAddPlacemark" type="submit" name="" value="Добавить метку">
		<input type="submit" name="" value="Сохранить">
	</div>
</div>
<script>
	ymaps.ready(usoftMapInit);
	var usoftMap, usoftMapCollection;
	var usoftMapCenter = {'lat':'<?=$arParams["LAT_MAIN"]?>', 'lon':'<?=$arParams["LON_MAIN"]?>', 'zoom':'<?=$arParams["ZOOM_MAIN"]?>'};
	
<?if ($arResult["ITEMS"]):?>
	var usoftPlacemarks = <?=CUtil::PhpToJSObject($arResult["ITEMS"])?>;
	console.log(usoftPlacemarks);
<?else:?>
	var usoftPlacemarks;
<?endif?>
</script>