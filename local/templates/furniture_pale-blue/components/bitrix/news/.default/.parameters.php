<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arTemplateParameters = array(
    "SPECIALDATE" => Array(
        "PARENT" => "ADDITIONAL_SETTINGS",
        "NAME" => GetMessage("SPECIALDATE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
    "REPORT_AJAX" => Array(
        "PARENT" => "ADDITIONAL_SETTINGS",
        "NAME" => GetMessage("REPORT_AJAX"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ),
);

