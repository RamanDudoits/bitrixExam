<?php
//namespace Prominado\Components;
//use Bitrix\Main\Engine\Contract\Controllerable;
//if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
//
//class Feedback extends \CBitrixComponent implements Controllerable
//{
//    // Обязательный метод
//    public function configureActions()
//    {
//        // Сбрасываем фильтры по-умолчанию (ActionFilter\Authentication и ActionFilter\HttpMethod)
//        // Предустановленные фильтры находятся в папке /bitrix/modules/main/lib/engine/actionfilter/
//        return [
//            'addElementIblock' => [ // Ajax-метод
//                'prefilters' => [],
//            ],
//        ];
//    }
//
//    // Ajax-методы должны быть с постфиксом Action
//    public function addElementIblockAction($GET)
//    {
//        $newElementIblock = array();
//        $user = '';
//        if ($USER->IsAuthorized()) {
//            $user = $USER->GetID() . " (" . $USER->GetLogin() . ") " . $USER->GetFullName();
//        } else {
//            $user = "Не авторизован";
//        }
//
//        $arFilds = [
//            "IBLOCK_ID" => 6,
//            'NAME' => 'Новость ' . $_GET['ID'],
//            'ACTIVE_FROM' => ConvertTimeStamp(time(), "FULL"),
//            'PROPERTY_VALUES' => [
//                'USER' => $user,
//                'NEWS' => $_GET['ID'],
//        ]];
//
//
//        $el = new CIBlockElement;
//        if($iElementId = $el->Add($arFilds))
//        {
//            $newElementIblock["ID"] = $iElementId;
//            if ($_GET['TYPE'] == 'REPORT_AJAX') {
//                $APPLICATION->RestartBuffer();
//                echo json_encode($newElementIblock);
//                exit;
//            } elseif ($_GET['TYPE'] == 'REPORT_GET') {
//                LocalRedirect($APPLICATION->GetCurPage() . "?TYPE=REPORT_RESULT&ID=" . $newElementIblock['ID']);
//            }
//        }
//    }
//
//    public function executeComponent()
//    {
//        if (isset($_GET['ID']) && Loader::includeModule('iblock'))
//        {
//            $this->includeComponentTemplate();
//        }
//    }
//}
