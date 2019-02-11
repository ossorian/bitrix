<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
global  $APPLICATION;
 
//nice presence of redirects! Just make 2 files with redirect in every row
$old = file($_SERVER['DOCUMENT_ROOT']."/redirect/oldones.php");
$new = file($_SERVER['DOCUMENT_ROOT']."/redirect/newones.php");
foreach($old as $code => $link)
{
    $link = trim($link);
	$curPage = $APPLICATION->GetCurPage();
    if (!empty($link) && $curPage==$link)
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: https://mesopharm-shop.ru".trim($new[$code]));
        exit();
    }
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Ошибка 404. Страница не найдена.");
?>
<div class="">Извините, но такой страницы не существует.<br>
    Вы можете <a href="/">Перейти на главную</a>, <a href="<?=SITE_DIR?>catalog/">Зайти  в каталог</a> или
    <a href="javascript:history.go(-1)">Вернуться назад</a>, на страницу с которой Вы пришли.</div>
<div class="clear"></div>
<div>
	<img style="width: 40%;padding-top: 20px;" src="/upload/medialibrary/301/Bez-imeni_2-obrezannyy-png.png" alt="Логотип компании Мезофарм">
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
