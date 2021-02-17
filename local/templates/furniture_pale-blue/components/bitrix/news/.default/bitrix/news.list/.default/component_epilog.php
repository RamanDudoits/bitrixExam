<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;
if (isset($arResult['FIRST_DATE'])) {
    $APPLICATION->SetPageProperty("specialdate", $arResult['FIRST_DATE']);
}
?>