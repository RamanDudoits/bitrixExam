<?php
//AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("ElementUpdate", "checkCount"));
//
//class ElementUpdate
//{
//    function checkCount(&$arFields)
//    {
//        $arFilter = array("ID" => $arFields["ID"]);
//        $arSelect = array("ID", "IBLOCK_ID", "NAME", "SHOW_COUNTER");
//
//        $result = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
//        if ($res = $result->Fetch()) {
//            if ($res["SHOW_COUNTER"] >= 2 && $arFields["ACTIVE"] == "N") {
//                global $APPLICATION;
//                $APPLICATION->throwException("Товар невозможно деактивировать, у него " . $res["SHOW_COUNTER"] . " просмотров");
//                return false;
//            }
//        }
//    }
//}

//echo '<pre>'; var_dump($res); echo '</pre>';
//?>


