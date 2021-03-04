<?php

use Bitrix\Main\Loader;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CJSCore::Init();

if ($_GET['TYPE'] == 'REPORT_RESULT') {
    echo '<script>';
    echo 'var textElem = document.getElementById("ajax-report-text");';
    if ($_GET['ID']) {
        echo 'textElem.innerText = "Ваше мнение учтено, №' . $_GET['ID'] . '";';
    } else {
        echo 'textElem.innerText = "Ошибка";';
    }
    echo '</script>';
} elseif (isset($_GET['ID']) && Loader::includeModule('iblock')) {

         $newElementIblock = array();

         $newElementIblock = array();
         $user = '';
         if ($USER->IsAuthorized()) {
             $user = $USER->GetID() . " (" . $USER->GetLogin() . ") " . $USER->GetFullName();
         } else {
             $user = "Не авторизован";
         }

         $arFields = [
             "IBLOCK_ID" => 6,
             'NAME' => 'Новость ' . $_GET['ID'],
             'ACTIVE_FROM' => ConvertTimeStamp(time(), "FULL"),
             'PROPERTY_VALUES' => [
                 'USER' => $user,
                 'NEWS' => $_GET['ID'],
             ]];

         $el = new CIBlockElement;
         if ($iElementId = $el->Add($arFields)) {
             $newElementIblock['ID'] = $iElementId;

             if ($_GET['TYPE'] == 'REPORT_AJAX') {
                 $APPLICATION->RestartBuffer();
                 echo json_encode($newElementIblock);
                 exit;
             } elseif ($_GET['TYPE'] == 'REPORT_GET') {
                 LocalRedirect($APPLICATION->GetCurPage() . "?TYPE=REPORT_RESULT&ID=" . $newElementIblock['ID']);
             }
         } else {
             LocalRedirect($APPLICATION->GetCurPage() . "?TYPE=REPORT_RESULT");
         }

}
