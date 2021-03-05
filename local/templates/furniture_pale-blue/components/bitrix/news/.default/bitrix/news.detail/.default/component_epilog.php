<?php

use Bitrix\Main\Loader;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$newElementIblock = $_GET["REPORT_ADD"];
CJSCore::Init();
if ($_GET['REPORT_ADD'] == 'Y') {
    $user = '';
    if ($USER->IsAuthorized()) {
        $user = $USER->GetID() . " (" . $USER->GetLogin() . ") " . $USER->GetFullName();
    } else {
        $user = "Не авторизован";
    }

    $arFields = [
        "IBLOCK_ID" => 6,
        'NAME' => 'Новость ' . $arResult['ID'],
        'ACTIVE_FROM' => ConvertTimeStamp(time(), "FULL"),
        'PROPERTY_VALUES' => [
            'USER' => $user,
            'NEWS' => $arResult['ID'],
        ]];
    $el = new CIBlockElement;
    if ($iElementId = $el->Add($arFields)) {
        $newElementIblock = $iElementId;
        if ($_GET['REPORT_ADD'] == 'Y') {
            LocalRedirect($APPLICATION->GetCurPage() . "?REPORT_ADD=" . $iElementId);
        }
    }
}
if (isset($newElementIblock)) {
    ?>
<script>
    var textElem = document.getElementById("ajax-report-text");
    var id = <?=$newElementIblock ? : 0?>;
    if(id){
        textElem.innerText = "Ваше мнение учтено, №" + id;
    } else textElem.innerText = "Ошибка";
</script>
<?} ?>