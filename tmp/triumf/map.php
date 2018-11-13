<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");?>

<?
if($_REQUEST['lang'])
{
    $_SESSION["LANGUAGE"] = $_REQUEST['lang'];
}

$map_lang = '';
if($_SESSION["LANGUAGE"] == "ENG")
{
    include 'lang/en.php';
    $map_lang = 'en-US';
}
elseif($_SESSION["LANGUAGE"] == "CHN")
{
    include 'lang/cn.php';
    $map_lang = 'zh-CN';
}
else
{
    include 'lang/ru.php';
    $map_lang = 'ru-RU';
}

?>

<?php session_start();
if (!isset($_SESSION['filter'])) $_SESSION['filter']=array();
require 'config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Карта</title>
<meta name="description" content="">
<meta name="Keywords" content="">
<link rel="stylesheet" href="css/fonts/styles.css" type="text/css">
<link rel="stylesheet" href="library/fancybox/jquery.fancybox.min.css" type="text/css">
<!--<link rel="stylesheet" href="library/owl/assets/owl.carousel.min.css" type="text/css">
<link rel="stylesheet" href="library/owl/assets/owl.theme.default.min.css" type="text/css">-->
<link rel="stylesheet" href="library/animate/animate.css" type="text/css">
<link rel="stylesheet" href="library/select/css/select2.min.css" type="text/css">
<link rel="stylesheet" href="library/jquery/jquery-ui.min.css" type="text/css">
<link rel="stylesheet" href="css/main.css" type="text/css">
<link rel="stylesheet" href="main2.css" type="text/css">
<link rel="stylesheet" href="flexslider.css" type="text/css">
<script src="jquery.js"></script>
<script src="modernizr.js"></script>
<script src="jquery.flexslider-min.js"></script>
<script src="https://api-maps.yandex.ru/2.1/?lang=<?= $map_lang?>"></script>
<script src="main2.js?<?php echo rand(); ?>"></script>
</head>
<body class="map-page">
<div id="myMap"></div>

	<!-- HEADER SECTION -->
	<header class="info">
		<div class="flex-row">
			<div class="logo">
				<img src="/newmap/images/logo.png" alt="">
			</div>
			<p class="logo-title"><?= $MESS['INVEST_MAP']?> <br/ ><?= $MESS['CITY_NAME']?></p>
			<!-- <div class="form-wrapper">
				<form action="post" id="search-form">
					<label class="search">
						<input type="search" name="search" placeholder="Поиск">
					</label>
				</form>
			</div> -->
			<!--<div class="vision-type">
				<div class="swith_item">
					<div class="onoffswitch">
						<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch">
						<label class="onoffswitch-label" for="myonoffswitch">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</div>-->
			<div id="lang-menu">
				<p id="lang_block">
					<a href = "/testmap/map.php?lang=RUS">RUS</a>
					<a href="/testmap/map.php?lang=ENG">ENG</a>
					<a href="/testmap/map.php?lang=CHN">CHN</a>
				</p>
			</div>
			<div class="mob_menu_btn cmn-toggle-switch cmn-toggle-switch__htx">
				<span>menu</span>
			</div>
		</div>
	</header>
	<!-- END HEADER SECTION -->
	<!-- SECTION MAP -->
	<section id="map">
		<div class="flex-row">
			<form class="map-filter">
			<?php
			get_filters($link,$_SESSION['filter']);
			?>
			</form>
			<div class="map-description">
				<div class="map-item">
                    <?
                    /*
					<div class="map-item__title">
						<!--заполняется в main2.js
							<div id="sync1" class="news-item-slider owl-carousel owl-theme">
							<div class="slider-item"><div class="image-wrapper"><img src="" alt=""></div></div>
						</div>
						<div id="sync2" class="owl-carousel owl-theme">
							<div class="slider-item"><div class="image-wrapper"><img src="" alt=""></div></div>
						</div>-->
					</div>


                    */
                    ?>
                    <div class="map-item__plus"></div>
                    <div class="map-item__close"></div>
                    <div id="item_card">

                    </div>


                    <?/*
					<div class="image-wrapper">
						
					</div>
					<div class="map-item__info">
						<div class="flex-row">
							<p>Инвестиции:</p>
							<p class="object_budget"></p>
						</div>
						<div class="flex-row">
							<p>Дата начала реализации:</p>
							<p class="object_date1"></p>
						</div>
						<div class="flex-row">
							<p>Дата планируемой сдачи проекта:</p>
							<p class="object_date2"></p>
						</div>
						<div class="flex-row">
							<p>Место реализации:</p>
							<p class="object_place"></p>
						</div>
						<div class="flex-row">
							<p class="object_file1"></p>
							<p class="object_file2"></p>
							<p class="object_file3"></p>
						</div>
					</div>
					<div class="map-item__table">
						<div class="object_html"></div>
					</div>

                    */?>
				</div>
				<div class="map-invest-projects mobile">
					<div class="map-item__title">
						<?= $MESS['INVEST_PROJ']?>
					</div>
					<!-- 1 -->
					<div class="map-invest-project">
						<div class="map-invest-project__title">Строительство Корбалихинского полиметалического рудника по добыче руды подземным способом</div>
						<div class="map-invest-project__description">
							<p>Администрацией города Горно-Алтайска объявлены конкурсы по отбору субъектов малого и среднего
								предпринимательства для предоставления им субсидий:на возмещение части затрат, связанных
								с приобретением оборудования в целях создания и (или) развития, и..... (или) модернизации
								производства товаров (работ, услуг);</p>
							<a href="#" class="read-more">
								<i class="icon icon_next"></i>Подробнее</a>
						</div>
					</div>
					<!-- 2 -->
					<div class="map-invest-project">
						<div class="map-invest-project__title">Строительство Корбалихинского полиметалического рудника по добыче руды подземным способом</div>
						<div class="map-invest-project__description">
							<p>Администрацией города Горно-Алтайска объявлены конкурсы по отбору субъектов малого и среднего
								предпринимательства для предоставления им субсидий:на возмещение части затрат, связанных
								с приобретением оборудования в целях создания и (или) развития, и..... (или) модернизации
								производства товаров (работ, услуг);</p>
							<a href="#" class="read-more">
								<i class="icon icon_next"></i>Подробнее</a>
						</div>
					</div>
					<!-- 3 -->
					<div class="map-invest-project">
						<div class="map-invest-project__title">Строительство Корбалихинского полиметалического рудника по добыче руды подземным способом</div>
						<div class="map-invest-project__description">
							<p>Администрацией города Горно-Алтайска объявлены конкурсы по отбору субъектов малого и среднего
								предпринимательства для предоставления им субсидий:на возмещение части затрат, связанных
								с приобретением оборудования в целях создания и (или) развития, и..... (или) модернизации
								производства товаров (работ, услуг);</p>
							<a href="#" class="read-more">
								<i class="icon icon_next"></i>Подробнее</a>
						</div>
					</div>
					<!-- 4 -->
					<div class="map-invest-project">
						<div class="map-invest-project__title">Строительство Корбалихинского полиметалического рудника по добыче руды подземным способом</div>
						<div class="map-invest-project__description">
							<p>Администрацией города Горно-Алтайска объявлены конкурсы по отбору субъектов малого и среднего
								предпринимательства для предоставления им субсидий:на возмещение части затрат, связанных
								с приобретением оборудования в целях создания и (или) развития, и..... (или) модернизации
								производства товаров (работ, услуг);</p>
							<a href="#" class="read-more">
								<i class="icon icon_next"></i>Подробнее</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- END SECTION MAP -->
	<!-- MODAL CONTENT -->
	<div class="modal-wrapper">
		<div class="modal-overflow"></div>
		<div class="modal-content">
			<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iusto fugiat ipsa suscipit libero, facilis obcaecati
				voluptatem accusantium natus explicabo, harum molestias dolore laborum dolores corrupti voluptas. Nesciunt
				fugiat repellat accusantium!</p>
		</div>
	</div>
	<!-- END MODAL CONTENT -->

	<div id="back-top" class="up_btn"></div>
	<div class="mobile_nav notfixed">
		<div class="mob_menu_wrapper">
			<!-- <div class="mob_menu-logo">
				<img src="./images/logo2.png" alt="">
			</div> -->
			<div class="mob_menu">
				<ul>
					<li class="has-sub">
						<a href="#">Господдержка</a>
						<ul class="sub-menu">
							<li>
								<a href="#">Финансовые меры поддержки</a>
							</li>
							<li>
								<a href="#">Нефинансовые меры поддержки</a>
							</li>
							<li>
								<a href="#">Нефинансовые меры поддержки</a>
							</li>
							<li>
								<a href="#">Заявка на получение мер господдержки</a>
							</li>
						</ul>
					</li>
					<li class="has-sub">
						<a href="#">О Республике Алтай </a>
						<ul class="sub-menu">
							<li>
								<a href="#">Власть</a>
							</li>
							<li>
								<a href="#">Административное деление и инвестиционные паспорта муниципальных образований </a>
							</li>
							<li>
								<a href="#">Геополитическое положение </a>
							</li>
							<li>
								<a href="#">Трудовые ресурсы</a>
							</li>
							<li>
								<a href="#">Экономика</a>
							</li>
							<li>
								<a href="#">Промышленность </a>
							</li>
							<li>
								<a href="#">Сельское хозяйство </a>
							</li>
							<li>
								<a href="#">Инвестиции </a>
							</li>
							<li>
								<a href="#">Внешнеэкономическая деятельность</a>
							</li>
							<li>
								<a href="#">Инновационный потенциал </a>
							</li>
							<li>
								<a href="#">Природные ресурсы </a>
							</li>
							<li>
								<a href="#">Транспортная инфраструктура </a>
							</li>
							<li>
								<a href="#">Энергетическая инфраструктура </a>
							</li>
							<li>
								<a href="#">Образовательная инфраструктура </a>
							</li>
							<li>
								<a href="#">Финансовая инфраструктура </a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Инвестиционное послание</a>
					</li>
					<li class="has-sub">
						<a href="#">Инвестиционные проекты</a>
						<ul class="sub-menu">
							<li>
								<a href="#">Реализованные проекты</a>
							</li>
							<li>
								<a href="#">Реализуемые проекты </a>
							</li>
							<li>
								<a href="#">Инвестиционные предложения </a>
							</li>
							<li>
								<a href="#">Реестр проектов </a>
							</li>
						</ul>
					</li>
					<li class="has-sub">
						<a href="#">Институты развития </a>
						<ul class="sub-menu">
							<li>
								<a href="#">Органы исполнительной власти (ОИВ)</a>
							</li>
							<li>
								<a href="#">Агенство стратегических инициатив (АСИ)</a>
							</li>
							<li>
								<a href="#">Гарантийный фонд Республики Алтай </a>
							</li>
							<li>
								<a href="#">Фонд поддержки малого и среднего предпринимательства Республики Алтай</a>
							</li>
							<li>
								<a href="#">Федеральная корпорация по развитию малого и среднего предпринимательства</a>
							</li>
							<li>
								<a href="#">Фонд развития промышленности</a>
							</li>
						</ul>
					</li>
					<li class="has-sub">
						<a href="#">Нормативно-правовая база </a>
						<ul class="sub-menu">
							<li>
								<a href="#">Федеральное законодательство</a>
							</li>
							<li>
								<a href="#">Региональное законодательство</a>
							</li>
							<li>
								<a href="#">Муниципальное законодательство </a>
							</li>
						</ul>
					</li>
					<li class="has-sub">
						<a href="#">Истории успеха</a>
						<ul class="sub-menu">
							<li>
								<a href="#">Общий список историй</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Новости</a>
					</li>
					<li>
						<a href="#">Инвестиционная карта</a>
					</li>
					<li class="has-sub">
						<a href="#">Проектное управление </a>
						<ul class="sub-menu">
							<li>
								<a href="#">Цели внедрения </a>
							</li>
							<li>
								<a href="#">Организационная структура </a>
							</li>
							<li>
								<a href="#">Методология </a>
							</li>
							<li>
								<a href="#">Реестр проектов </a>
							</li>
							<li>
								<a href="#">Решения Организационного штаба </a>
							</li>
							<li>
								<a href="#">Библиотека </a>
							</li>
						</ul>
					</li>
					<li class="has-sub">
						<a href="#">Стратегические документы</a>
						<ul class="sub-menu">
							<li>
								<a href="#">Стратегия социально-экономического развития Республики Алтай</a>
							</li>
							<li>
								<a href="#">План создания инвестиционных объектов </a>
							</li>
							<li>
								<a href="#">План мероприятий по улучшению состояния инвестиционного климата в Республике Алтай, инвестиционную
									стратегию Республики Алтай </a>
							</li>
						</ul>
					</li>
					<li class="has-sub">
						<a href="#">Инвестиционные площадки </a>
						<ul class="sub-menu">
							<li>
								<a href="#">Бизнес-инкубаторы</a>
							</li>
							<li>
								<a href="#">Браунфилды</a>
							</li>
							<li>
								<a href="#">Гринфилды</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Мероприятия</a>
					</li>
					<li>
						<a href="#">Презентации инвестиционных проектов</a>
					</li>
					<li class="has-sub">
						<a href="#">Режим "Одного окна" </a>
						<ul class="sub-menu">
							<li>
								<a href="#">Инвестору</a>
							</li>
							<li>
								<a href="#">Регламент комплексного сопровождения инвестиционных проектов по принципу «одного окна» </a>
							</li>
						</ul>
					</li>
					<li class="has-sub">
						<a href="#">Режим "Одного окна" </a>
						<ul class="sub-menu">
							<li>
								<a href="#">Инвестору</a>
							</li>
							<li>
								<a href="#">Регламент комплексного сопровождения инвестиционных проектов по принципу «одного окна» </a>
							</li>
						</ul>
					</li>
					<li class="has-sub">
						<a href="#">Линия прямых обращений</a>
						<ul class="sub-menu">
							<li>
								<a href="#">Подать обращение</a>
							</li>
							<li>
								<a href="#">Каналы прямой связи инвесторов с руководством Республики Алтай</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Агентство сопровождения инвестиционных проектов в Республике Алтай</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- Our scripts -->
	<script src="library/select/js/select2.full.min.js"></script>
	<script src="library/fancybox/jquery.fancybox.min.js"></script>
	<script src="library/owl/owl.carousel.min.js"></script>
	<script src="library/mask/jquery.maskedinput.js"></script>
	<script src="library/tabs/tabs.js"></script>
	<script src="./library/jquery/jquery-ui.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
<?php
function get_filters($link,$filter) {


    global $DB, $MESS;

    echo '<div class="filter-line"><div class="filter-line__title">'.$MESS['INVEST_PROJ'].'</div></div>';
    echo '<div class="filter-line '.'projects'.'"><div class="filter-line__subtitle">'.$MESS['PROJ_STATUS'].'</div>';



    $propertyStatus = 7;
    $propertySectors  = 9;

    if($_SESSION["LANGUAGE"] == "ENG")
    {
        $propertyStatus = 58;
        $propertySectors  = 59;
    }
    elseif($_SESSION["LANGUAGE"] == "CHN")
    {
        $propertyStatus = 79;
        $propertySectors  = 80;
    }


    $strSql = "SELECT * FROM b_iblock_property_enum WHERE PROPERTY_ID = '" . $propertyStatus . "'";
    $rs = $DB->Query($strSql);

    $ar = array();
    while($elem = $rs->Fetch())
    {
        $ar[] = $elem ;
    }


    //echo '<pre>';
        //var_dump($ar);
    //echo '<pre>';

        foreach($ar as $i=>$variant) {
    ?>
    <div class="checkbox-wrapper">
        <?php echo '<input type="checkbox" name="filter_'.$variant["PROPERTY_ID"].'_'.$variant["ID"].'" id="filter_'.$variant["PROPERTY_ID"].'_'.$variant["ID"].'" data-id="'.$id.'" data-type="'.'projects'.'" value="'.trim($variant["VALUE"]).'" class="checkbox" hidden="" checked>'; ?>
        <label for="filter_<?php echo $variant["PROPERTY_ID"].'_'.$variant["ID"]; ?>" class="checkbox-label">
            <p class="active"><?php echo trim($variant["VALUE"]); ?></p>
        </label>
    </div>
    <?php }
    echo '</div>';
    echo '<div class="filter-line '.'projects'.'"><div class="filter-line__subtitle">'.$MESS['INDUST'].'</div>';

    $strSql = "SELECT * FROM b_iblock_property_enum WHERE PROPERTY_ID = '" . $propertySectors . "'";
    $rs = $DB->Query($strSql);

    $ar = array();
    while($elem = $rs->Fetch())
    {
        $ar[] = $elem ;
    }


    //echo '<pre>';
    //var_dump($ar);
    //echo '<pre>';

    foreach($ar as $i=>$variant) {
        ?>
        <div class="checkbox-wrapper">
            <?php echo '<input type="checkbox" name="filter_'.$variant["PROPERTY_ID"].'_'.$variant["ID"].'" id="filter_'.$variant["PROPERTY_ID"].'_'.$variant["ID"].'" data-id="'.$id.'" data-type="'.'projects'.'" value="'.trim($variant["VALUE"]).'" class="checkbox" hidden="" checked>'; ?>
            <label for="filter_<?php echo $variant["PROPERTY_ID"].'_'.$variant["ID"]; ?>" class="checkbox-label">
                <p class="active"><?php echo trim($variant["VALUE"]); ?></p>
            </label>
        </div>
    <?php }


        echo '</div>';

    $strSql = "SELECT MAX(`VALUE_NUM`) FROM b_iblock_element_property WHERE IBLOCK_PROPERTY_ID = '" . 10 . "' LIMIT 1";
    $rs = $DB->Query($strSql);

    $ar = array();
    while($elem = $rs->Fetch())
    {
        $ar = $elem ;
    }

    //echo '<pre>';
    //var_dump($ar);
    //echo '<pre>';


        $max_budget=$ar["MAX(`VALUE_NUM`)"];


    ?>
    <div class="filter-line">
        <div class="filter-line__subtitle"><?= $MESS['INVEST_VOLUME']?></div>


        <p class="range-text"><?= $MESS['RANGE']?>:
            <span>0 - <?php echo intval($max_budget); ?></span> <?= $MESS['MILLIONS_RUB']?></p>
        <input type="range" id="range1" class="hidden">
        <div id="id1-range" class="range-wrapper" data-max="<?php echo intval($max_budget); ?>"></div>
    </div>

    <?php

    if (($result = mysqli_query($link,"SELECT id,name,type,variants FROM filters ORDER BY id")) && mysqli_num_rows($result)>0) {
        $first_region=true;
        $first_infrastructure=true;
        while ($row = $result->fetch_assoc()) {
            $id=$row['id'];
			if ($row['type']=='sites'){
				echo '<div class="filter-line '.$row['type'].'"><div class="filter-line__title">'.$MESS['INVEST_SITE'].'</div>';
				foreach(explode("\n",$row['variants']) as $i=>$variant) if (trim($variant)!='') {
			?>
			<div class="checkbox-wrapper">
				<?php echo '<input type="checkbox" name="filter'.$id.'_'.$i.'" id="filter'.$id.'_'.$i.'" data-id="'.$id.'" data-type="'.$row['type'].'" value="'.trim($variant).'" class="checkbox" hidden="" checked>'; ?>
				<label for="filter<?php echo $id.'_'.$i; ?>" class="checkbox-label">
					<p class="active"><?php echo trim($variant); ?></p>
				</label>
			</div>
			<?php }
				echo '</div>';
			} else if ($row['type']=='infrastructure') {
				if($first_infrastructure) {
					echo '<div class="filter-line"><div class="filter-line__title">'.$MESS['INFRASTUCT'].'</div></div>';
					$first_infrastructure=false;
				}
				echo '<div class="'.$row['type'].'"><div class="show-hidden-filters"><input type="checkbox" name="type" id="filter_inf'.$id.'" data-id="'.$id.'" value="'.$row['name'].'" class="checkbox" hidden=""><span class="active">'.$row['name'].'</span></div><div class="hidden-filters subfilter'.$id.'">';
				foreach(explode("\n",$row['variants']) as $i=>$variant) if (trim($variant)!='') {
				?>
			<div class="checkbox-wrapper">
				<?php echo '<input type="checkbox" name="filter'.$id.'_'.$i.'" id="filter'.$id.'_'.$i.'" data-id="'.$id.'" data-type="'.$row['type'].'" value="'.trim($variant).'" class="checkbox" hidden="" checked>'; ?>
				<label for="filter<?php echo $id.'_'.$i; ?>" class="checkbox-label">
					<p class="active"><?php echo trim($variant); ?></p>
				</label>
			</div>
			<?php }
				echo '</div></div>';
			} else if ($row['type']=='regions') {
				if($first_region) {
					echo '<div class="filter-line '.$row['type'].'"><div class="filter-line__title">'.$MESS['MUNICIPAL'].'</div><div id="regions_onoff"><span id="regions_on">'.$MESS['SELECT_ALL'].'</span><span id="regions_off">'.$MESS['RESET_ALL'].'</span></div>';
					$first_region=false;
				}
			?>
			<div class="checkbox-wrapper">
				<?php echo '<input type="checkbox" name="filter'.$id.'_'.$i.'" id="filter'.$id.'_'.$i.'" data-id="'.$id.'" data-type="'.$row['type'].'" value="'.trim($variant).'" class="checkbox" hidden="" checked>'; ?>
				<label for="filter<?php echo $id.'_'.$i; ?>" class="checkbox-label">
					<p class="active"><?php echo $row['name']; ?></p>
				</label>
			</div>
			<?php
				if($id==15) echo '</div>';
			}
		} //end while
	} //end query
}
function reverse_dt($date) {
	if(strpos($date,'-')===false) return $date;
	$arr=explode('-',$date);
	return $arr[2].'-'.$arr[1].'-'.$arr[0];
}
?>

<script>
    ymaps.ready(function () {
        var myMap = new ymaps.Map('myMap', {center:[48.455184,135.138990], zoom:11, controls:['typeSelector']});
        myMap.controls.add(new ymaps.control.SearchControl({options: { position: { right: 150, top: 10 }}}));
        myMap.controls.add(new ymaps.control.ZoomControl({options: { position: { right: 10, top: 50 }}}));

        OM_sites = new ymaps.ObjectManager({
            clusterize: true,
            gridSize: 32
        });
        myMap.geoObjects.add(OM_sites);
        OM_infrastructure = new ymaps.ObjectManager({
            clusterize: true,
            gridSize: 32
        });
        myMap.geoObjects.add(OM_infrastructure);

        OM_projects = new ymaps.ObjectManager({
            clusterize: true,
            gridSize: 32
        });
        $.ajax({
            url: "objects_ajax.php?type=projects&lang=<?$_SESSION["LANGUAGE"]?>"
            //url: "objects_ajax.php?type=projects"
        }).done(function(data) {
            OM_projects.add(data);
            myMap.geoObjects.add(OM_projects);
        });
        $.ajax({
            url: "objects_ajax.php?type=sites"
        }).done(function(data) {
            OM_sites.add(data);
        });
        $.ajax({
            url: "objects_ajax.php?type=infrastructure"
        }).done(function(data) {
            OM_infrastructure.add(data);
        });
        OM_regions = new ymaps.ObjectManager();
        $.getJSON('regions_ajax.json').done(function (geoJson) {
            OM_regions.add(geoJson);
            myMap.geoObjects.add(OM_regions);
        });

        OM_projects.objects.events.add('click', function(e){
            show_object(e,OM_projects);
        });
        OM_sites.objects.events.add('click', function(e){
            show_object(e,OM_sites);
        });
        OM_infrastructure.objects.events.add('click', function(e){
            show_object(e,OM_infrastructure);
        });

        function show_object(e,OM) {
            var id = e.get('objectId');
            var obj = OM.objects.getById(id).properties;
            var lang = '<?= $_SESSION["LANGUAGE"]?>';


            console.log(OM.objects.getById(id));


            $.ajax({
                url: "object_ajax.php",
                data: {
                    'id': id,
                    'site_lang': lang
                },
                dataType: 'html'
                //url: "objects_ajax.php?type=projects"
            }).done(function(data) {
                //alert('done');
                $('#item_card').html(data);
                $('.map-description').removeClass('active');

                $('.map-description').css('margin-left','-100%').attr('id',id).attr('type',obj.type).addClass('active');
                $('.map-description').animate({marginLeft:'0px'},1000);
            });

        }

        $('.map-item__plus').click(function(){
            var id=$('.map-description').attr('id');
            var type=$('.map-description').attr('type');
            switch(type){
                case 'projects':
                    var point=OM_projects.objects.getById(id).geometry.coordinates;
                    myMap.setZoom(14);
                    myMap.panTo(point);
                    break;
                case 'sites':
                    var point=OM_sites.objects.getById(id).geometry.coordinates;
                    myMap.setZoom(14);
                    myMap.panTo(point);
                    break;
                case 'infrastructure':
                    var point=OM_infrastructure.objects.getById(id).geometry.coordinates;
                    myMap.setZoom(14);
                    myMap.panTo(point);
                    break;
            }

        });
        $('.map-item__close').click(function(){
            $('.map-description').removeClass('active');
            $('.image-wrapper').empty();
        });

        $('.projects [type=checkbox]').change(createFilter);
        $( "#id1-range" ).on( "slidechange",(createFilter));

        $('.sites [type=checkbox]').change(function(){
            var ids=[];
            $('.sites [type=checkbox]').each(function(i,el) {
                if($(el).prop('checked')) ids.push('properties.filter['+$(el).data('id')+']=="'+$(el).val()+'"');
            });
            if(ids.length==0) OM_sites.setFilter('id==0');
            else OM_sites.setFilter(ids.join(' || '));
        });

        //изначально все спрятаны
        OM_infrastructure.setFilter('id==0');
        $('.infrastructure span').click(function(){
            $(this).toggleClass('active');
            var checkbox=$(this).prev();
            checkbox.prop('checked',!checkbox.prop('checked'));
            var id=checkbox.data('id');
            $('.hidden-filters.subfilter'+id).toggle('slow');
            $('.hidden-filters.subfilter'+id+' [type=checkbox]').each(function(i,e){
                $(e).prop('checked',checkbox.prop('checked'));
            })
            var ids=[];
            $('.infrastructure [type=checkbox]').each(function(i,el) {
                if($(el).prop('checked')) ids.push('properties.filter['+$(el).data('id')+']=="'+$(el).val()+'"');
            });
            if(ids.length==0) OM_infrastructure.setFilter('id==0');
            else OM_infrastructure.setFilter(ids.join(' || '));
        });
        $('.infrastructure [type=checkbox]').change(function(){
            if($('.infrastructure>input').index(this)>=0) {
                var id=$(this).data('id');
                $('.subfilter'+id+' [type=checkbox]').prop('checked',$(this).prop("checked"));
            }
            var ids=[];
            $('.infrastructure [type=checkbox]').each(function(i,el) {
                if($(el).prop('checked')) ids.push('properties.filter['+$(el).data('id')+']=="'+$(el).val()+'"');
            });
            if(ids.length==0) OM_infrastructure.setFilter('id==0');
            else OM_infrastructure.setFilter(ids.join(' || '));
        });

        $('.regions [type=checkbox]').change(function(){
            var ids=[];
            $('.regions [type=checkbox]').each(function(i,el) {
                if($(el).prop('checked')) ids.push($(el).data('id'));
            });
            if(ids.length==0) OM_regions.setFilter('id==0');
            else OM_regions.setFilter('id=='+ids.join(' || id=='));
        })
        $('#regions_on').click(function(e){
            $('.regions [type=checkbox]').prop('checked',true);
            $('.regions [type=checkbox]').eq(0).change();
        });
        $('#regions_off').click(function(e){
            $('.regions [type=checkbox]').prop('checked',false);
            $('.regions [type=checkbox]').eq(0).change();
        });
//	myMap.setBounds(clusterer.getBounds(), { checkZoomRange: true });

        function createFilter() {
            var id_status=[],id_industry=[];
            $('[type=checkbox]','.projects:eq(0)').each(function(i,el) {
                if($(el).prop('checked')) id_status.push($(el).val());
            });
            $('[type=checkbox]','.projects:eq(1)').each(function(i,el) {
                if($(el).prop('checked')) id_industry.push($(el).val());
            });
            OM_projects.setFilter(function(obj){
                f=obj.properties.filter;
                res1=false;
                res2=false;
//			console.log(obj.id,f,obj.properties.budget);
                for (var i in f){
//				console.log(i,f[i]);
                    for (var j = 0; j < f[i].length; j++) {
                        for (var k = 0; k < id_status.length; k++) {
                            if (id_status[k]==f[i][j]) res1=true;
//						console.log(f[i][j],(id_status[k]==f[i][j]));
                        }
                        for (var k = 0; k < id_industry.length; k++) {
                            if (id_industry[k]==f[i][j]) res2=true;
//						console.log(f[i][j],(id_industry[k]==f[i][j]));
                        }
                    }
                }
                var min=$('#id1-range').slider( "values",0 );
                var max=$('#id1-range').slider( "values",1 );
                res3=(obj.properties.budget>=min) && (obj.properties.budget<=max);
//			console.log(min,max,res3);
                result=res1&&res2&&res3;
//			console.log(res1,res2,res3,result);
                return result;
            });
        }
    });
</script>
