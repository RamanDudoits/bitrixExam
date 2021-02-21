<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $USER;

if (CModule::IncludeModule("iblock")) {

    if ($this->startResultCache(false, array($USER->GetGroups()))) {
        $arClassif = array();
        $arClassifId = array();
        $arResult["COUNT"] = 0;

        $arSelectElements = array(
            "ID",
            "IBLOCK_ID",
            "NAME",
        );

        $arFilterElements = array(
            "IBLOCK_ID" => $arParams["CLASS_IBLOCK_ID"],
            "CHECK_PERMISSIONS" => $arParams["CACHE_GROUPS"],
            "ACTIVE" => "Y"
        );

        $rsElements = CIBlockElement::GetList($arParams, $arFilterElements, false, false, $arSelectElements);

        while ($arElement = $rsElements->GetNext()) {
            $arClassif[$arElement["ID"]] = $arElement;
            $arClassifId[] = $arElement["ID"];
        }
        $arResult["COUNT"] = count($arClassifId);
        $arSelectElementsCatalog = array(
            "ID",
            "IBLOCK_ID",
            "IBLOCK_SECTION_ID",
            "NAME",

        );

        $arFilterElementsCatalog = array(
            "IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
            "CHECK_PERMISSIONS" => $arParams["CACHE_GROUPS"],
            "PROPERTY_" . $arParams["PROPERTY_CODE"] => $arClassifId,
            "ACTIVE" => "Y"
        );

        $arResult["ELEMENTS"] = array();
        $rsElements = CIBlockElement::GetList($arParams, $arFilterElementsCatalog, false, false, $arSelectElementsCatalog);
        while ($rsEl = $rsElements->GetNextElement()) {
            $arField = $rsEl->GetFields();
            $arField["PROPERTY"] = $rsEl->GetProperties();

            foreach ($arField["PROPERTY"]["FIRMA"]["VALUE"] as $value) {
                $arClassif[$value]["ELEMENTS"][$arField["ID"]] = $arField;
            }
        }
        $arResult["CLASSIF"] = $arClassif;

//    echo '<pre>'; var_dump($arField["PROPERTY"]); echo '</pre>';
        $this->includeComponentTemplate();
        $this->SetResultCacheKeys(array("COUNT"));
    } else {
        $this->abortResultCache();
    }

    $APPLICATION->SetTitle(GetMessage("COUNT") . $arResult["COUNT"]);
}