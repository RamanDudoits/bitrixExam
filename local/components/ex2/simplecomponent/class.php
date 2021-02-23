<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

Class CSimpleComp extends CBitrixComponent
{
    public $user;
    public $application;

    function __construct($component = null)
    {
        parent::__construct($component);
        global $USER;
        global $APPLICATION;

        $this->user = $USER;
        $this->application = $APPLICATION;
    }

    public function loadModules()
    {
        if ( !\Bitrix\Main\Loader::includeModule('iblock') )
        {
            $this->AbortResultCache();
        }
    }
    public function getResult ()
    {
            $arClassif = array();
            $arClassifId = array();
            $arResult["COUNT"] = 0;


        $arSelectElements = array(
            "ID",
            "IBLOCK_ID",
            "NAME",
        );

        $arFilterElements = array(
            "IBLOCK_ID" => $this->arParams["CLASS_IBLOCK_ID"],
            "CHECK_PERMISSIONS" => $this->arParams["CACHE_GROUPS"],
            "ACTIVE" => "Y"
        );

       $rsElements = CIBlockElement::GetList(array(), $arFilterElements, false, false, $arSelectElements);

//            $rsElements = CIBlockElement::getList(array(
//                'select' => array('ID', "IBLOCK_ID", "NAME"),
//                'filter' => array(
//                    "IBLOCK_ID" => $this->arParams["CLASS_IBLOCK_ID"],
//                    "CHECK_PERMISSIONS" => $this->arParams["CACHE_GROUPS"],
//                    "ACTIVE" => "Y"),
//            ));

            while ($arElement = $rsElements->fetch()) {
                $arClassif[$arElement["ID"]] = $arElement;
                $arClassifId[] = $arElement["ID"];
            }

            $this->arResult["COUNT"] = count($arClassifId);
            $arSelectElementsCatalog = array(
                "ID",
                "IBLOCK_ID",
                "IBLOCK_SECTION_ID",
                "NAME",

            );

            $arFilterElementsCatalog = array(
                "IBLOCK_ID" => $this->arParams["PRODUCTS_IBLOCK_ID"],
                "CHECK_PERMISSIONS" => $this->arParams["CACHE_GROUPS"],
                "PROPERTY_" . $this->arParams["PROPERTY_CODE"] => $arClassifId,
                "ACTIVE" => "Y"
            );

            $arResult["ELEMENTS"] = array();

            $rsElements = CIBlockElement::GetList($this->arParams, $arFilterElementsCatalog, false, false, $arSelectElementsCatalog);
        while ($rsEl = $rsElements->GetNextElement()) {
            $arField = $rsEl->GetFields();
            $arField["PROPERTY"] = $rsEl->GetProperties();
            foreach ($arField["PROPERTY"]["FIRMA"]["VALUE"] as $value) {
                $arClassif[$value]["ELEMENTS"][$arField["ID"]] = $arField;
            }
        }
            echo "<pre>"; print_r($arClassif[$value]["ELEMENTS"][$arField["ID"]]); echo "</pre>";

            $this->arResult["CLASSIF"] = $arClassif;

            $this->SetResultCacheKeys(array("COUNT"));

    }

    public function executeComponent()
    {
        $this->loadModules();

        $groups = $this->user->GetGroups();
        if ( $this->startResultCache(false, $groups) )
        {
            $this->getResult();
            $this->includeComponentTemplate();
        } else {
            $this->abortResultCache();
        }
        $this->application->SetTitle("Разделов - ". $this->arResult["COUNT"]);
    }
}