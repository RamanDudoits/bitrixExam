<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
		    "NAME" => GetMessage("SIMPLE_COM_IBLOCK_ID"),
            "TYPE" => "STRING",
		),
        "CLASS_IBLOCK_ID" => array(
            "NAME" => GetMessage("SIMPLE_COM_CLASS"),
            "TYPE" => "STRING",
        ),
        "TEMPLATE" => array(
            "NAME" => GetMessage("SIMPLE_COM_TEMPLATE"),
            "TYPE" => "STRING",
        ),
        "PROPERTY_CODE" => array(
            "NAME" => GetMessage("SIMPLE_COM_PROPERTY"),
            "TYPE" => "STRING",
        ),
        "CACHE_TIME"  =>  array("DEFAULT"=>36000000),
        "CACHE_GROUPS" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("CP_BNL_CACHE_GROUPS"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
	),
);