<?php
//Фишка. Можно вставлять код на страницу для автоматической перезагрузки:
//<script>window.location.href = '/local/php_interface/_tools/migrateUsers/Migration.php?PAGE=$nextPage'</script>

//Пример кода ниже:


require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main;
use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock')) {
    throw new Main\LoaderException("The required modules are not installed");
}

global $isSync;
$isSync = true;

class Migration
{
    const USER_PER_STEP = 20;
	const LOG_DIR = '/local/php_interface/_tools/migrateUsers/';

    public static function sync()
    {
        $usersArr = self::getArrayUsers();
        $count = count($usersArr);
        $page = $_GET["PAGE"] ?: 0;
        $nextPage = $page + 1;
        $maxPage = ceil($count / self::USER_PER_STEP);
        for ($i = self::USER_PER_STEP * $page; $i < self::USER_PER_STEP * $nextPage; $i++) {
            $user = $usersArr[$i];
            if ($user) {
                $fio = self::getUserNameArr($user['fio']);
                $password = self::generatePassword();
                $arFields = Array(
                    "NAME" => $fio[1],
                    "LAST_NAME" => $fio[0],
                    "SECOND_NAME" => $fio[2],
                    "EMAIL" => $user['email'],
                    "LOGIN" => $user['email'],
                    "LID" => "ru",
                    "ACTIVE" => $user['is_active'] == '1'? "Y" : "N",
                    "PASSWORD" => $password,
                    "CONFIRM_PASSWORD" => $password,
                    "PERSONAL_PHONE" => $user['phones'],
                    "UF_CERT_COSMETOLOG" => self::saveImage($user['beautician_diploma_file']),
                    "UF_CERT_EDUCATION" => self::saveImage($user['medical_education_file']),
                    "UF_CERT_COURSES" => self::saveImage($user['training_file']),
                    "UF_PASSPORT" => self::saveImage($user['passport_file']),
                    "UF_NEED_CHECK" => false,
                    "PERSONAL_CITY" => $user['city'] ?: "",
                    "PERSONAL_STREET" => $user['address'] ?: "",
//                    "UF_DISCOUNT" => $user['discount'] ?: 0,
                    "GROUP_ID" => $user['status'] == '1'? [9] : [6],
					"UF_OLDSITE_USER_ID" => intval($user['id']),
                );
                if (self::createUser($arFields)) self::saveToLog('amount', $i, true);

            }
        }
        $countUsers = self::USER_PER_STEP * $nextPage;
        echo "Пользователей перенесено: $countUsers из $count \n";
        echo "Страница $nextPage из $maxPage \n";
        if ($nextPage < $maxPage) {
            echo "<script>window.location.href = '/local/php_interface/_tools/migrateUsers/Migration.php?PAGE=$nextPage'</script>";
        } else {
            die('Все пользователи перенесены!');
        }
    }

    public static function getArrayUsers()
    {
        $usersJson = file_get_contents($_SERVER["DOCUMENT_ROOT"].self::LOG_DIR.'data.json');
        $userArray = json_decode($usersJson, true);
        return $userArray['users'];
    }

    public static function getUserNameArr($fio)
    {
        return explode(' ', $fio);
    }
	
    public static function saveImage($url)
    {
		return self::saveImageAdvanced($url);
		
/*         if (!$url) {
            return false;
        }
        $urlArr = explode('/', $url);
        $filename = $urlArr[2];
        $image = file_get_contents('http://www.mesopharm.ru/' . $url);
        $path = '/upload/tmp_image/';
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $path)) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . $path, 0777, true);
        }
        $path .= 'tmp_' . $filename;
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $path)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $path);
        }
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . $path, $image);
        $fileArr = \CFile::MakeFileArray($path);
        $fileArr['del'] = 'Y';
        if ($fileArr['size'] === 0) {
            return false;
        }
        return $fileArr;
 */    }

    public static function createUser($arFields)
    {
        $user = new CUser;
        $ID = $user->Add($arFields);
        if (!(intval($ID) > 0)) {
            Main\Diag\Debug::writeToFile(array('UserEmail' => $arFields['EMAIL'], 'fields' => $arFields, 'error' => $user->LAST_ERROR), $arFields['EMAIL'] . ' - ' . date("d-M-Y H:i:s"), '/local/php_interface/_tools/migrateUsers/log.txt');
			
			self::saveToLog('wrong', $arFields["UF_OLDSITE_USER_ID"].',', false);
			self::saveToLog('last', $arFields["UF_OLDSITE_USER_ID"], true);
			return false;
        }
		return true;
    }

    public static function generatePassword()
    {
        $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        $max = 10;
        $size = StrLen($chars) - 1;
        $password = null;
        while ($max--) {
            $password .= $chars[rand(0, $size)];
        }
        return $password;
    }

	//additional information logs
	private static function saveToLog($name, $value, $reset = false)
	{
		file_put_contents($_SERVER["DOCUMENT_ROOT"].self::LOG_DIR.$name.'-log.txt', $value, $reset ? 0 : FILE_APPEND);
	}
	
	private function  saveImageAdvanced($url)
    {
        if (!$url) return false;
		
		$oldPath = 'http://www.mesopharm.ru/' . $url;
        $filename = basename($url);
        $newPath = $_SERVER['DOCUMENT_ROOT'].'/upload/tmp_image/';
		
        if (!file_exists($newPath)) {
            mkdir($path, 0777, true);
        }
		
        $newPath .= 'tmp_' . $filename;
		copy($oldPath, $newPath);
		
        $fileArr = \CFile::MakeFileArray($newPath);
		$fileArr['name'] = $filename;
        $fileArr['del'] = 'Y';
        if ($fileArr['size'] === 0) {
            return false;
        }
		return $fileArr;
    }
}
