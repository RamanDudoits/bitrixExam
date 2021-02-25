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

//  Old API
//        $arSelectElements = array(
//            "ID",
//            "IBLOCK_ID",
//            "NAME",
//        );
//
//        $arFilterElements = array(
//            "IBLOCK_ID" => $this->arParams["CLASS_IBLOCK_ID"],
//            "CHECK_PERMISSIONS" => $this->arParams["CACHE_GROUPS"],
//            "ACTIVE" => "Y"
//        );
//
//        $rsElements = CIBlockElement::GetList(array(), $arFilterElements, false, false, $arSelectElements);
//        while ($arElement = $rsElements->fetch()) {
//            $arClassif[$arElement["ID"]] = $arElement;
//            $arClassifId[] = $arElement["ID"];
//
//        }
//
//        $this->arResult["COUNT"] = count($arClassifId);
//        $arSelectElementsCatalog = array(
//            "ID", "IBLOCK_ID", 'NAME',
//            "PROPERTY_PRICE", "PROPERTY_MATERIAL",
//            "PROPERTY_ARTNUMBER", "DETAIL_PAGE_URL","PROPERTY_" . $this->arParams["PROPERTY_CODE"]
//        );
//
//        $arFilterElementsCatalog = array(
//            "IBLOCK_ID" => $this->arParams["PRODUCTS_IBLOCK_ID"],
//            "CHECK_PERMISSIONS" => $this->arParams["CACHE_GROUPS"],
//            "PROPERTY_" . $this->arParams["PROPERTY_CODE"] => $arClassifId,
//            "ACTIVE" => "Y"
//        );
//
//        $rsElements = CIBlockElement::GetList($this->arParams, $arFilterElementsCatalog, false, false, $arSelectElementsCatalog);
//        while ($rsEl = $rsElements->fetch())
//        {
//            foreach ($arClassif as $key => $value)
//            {
//                if ($key == $rsEl["PROPERTY_FIRMA_VALUE"])
//                {
//                    array_push($arClassif[$key], $rsEl);
//                }
//            }
//        }


        $rsElements = Bitrix\Iblock\ElementTable::getList(array(
                'select' => array(
                    "ID",
                    "IBLOCK_ID",
                    "NAME",
                    "GROUP_PERM.PERMISSION",
                    "GROUP_PERM.GROUP_ID",
                    ),
                'filter' => array(
                    "IBLOCK_ID" => $this->arParams["CLASS_IBLOCK_ID"],
                    "ACTIVE" => "Y",
                    "GROUP_PERM.PERMISSION" => ["R", "X", "W"],
                    "GROUP_PERM.GROUP_ID" => explode(",", $this->user->GetGroups()),
                    ),
            'runtime' => [
                (new Bitrix\Main\ORM\Fields\Relations\Reference('GROUP_PERM', \Bitrix\Iblock\IblockGroupTable::class,
                    Bitrix\Main\ORM\Query\Join::on('this.IBLOCK_ID', 'ref.IBLOCK_ID')))
                ->configureJoinType('inner')]
            ));


            while ($arElement = $rsElements->fetch()) {
                $arClassif[$arElement["ID"]] = $arElement;
                $arClassifId[$arElement["ID"]] = $arElement["ID"];
            }



        $rsElements = Bitrix\Iblock\ElementTable::getList(array(
            'select' => array(
                "ID", "IBLOCK_ID", 'NAME',
//                "PROPERTY_PRICE", "PROPERTY_MATERIAL",
//                "PROPERTY_ARTNUMBER", "DETAIL_PAGE_URL","PROPERTY_" . $this->arParams["PROPERTY_CODE"],
                "GROUP_PERM.PERMISSION",
                "GROUP_PERM.GROUP_ID",
            ),
            'filter' => array(
                "IBLOCK_ID" => $this->arParams["PRODUCTS_IBLOCK_ID"],
//                "PROPERTY_" . $this->arParams["PROPERTY_CODE"] => $arClassifId,
//                "ACTIVE" => "Y",
//                "GROUP_PERM.PERMISSION" => ["R", "X", "W"],
//                "GROUP_PERM.GROUP_ID" => explode(",", $this->user->GetGroups()),
            ),
            'runtime' => [
                (new Bitrix\Main\ORM\Fields\Relations\Reference('GROUP_PERM', \Bitrix\Iblock\IblockGroupTable::class,
                    Bitrix\Main\ORM\Query\Join::on('this.IBLOCK_ID', 'ref.IBLOCK_ID')))
                    ->configureJoinType('inner')]
        ));

        while ($rsEl = $rsElements->fetch())
        {
            foreach ($arClassif as $key => $value)
            {
                if ($key == $rsEl["PROPERTY_FIRMA_VALUE"])
                {
                    array_push($arClassif[$key], $rsEl);
                }
            }
        }

        echo "<pre>"; var_dump( $arClassif); echo "</pre>";




            $this->arResult["COUNT"] = count($arClassif);
            $this->arResult["CLASSIF"] = $arClassif;
            $this->SetResultCacheKeys(array("COUNT"));
    }

    public function executeComponent()
    {
        $this->loadModules();
        $groups = $this->user->GetGroups();
        if ( $this->startResultCache(false, $groups) )
        {
            if (!in_array(1, $groups))
            {
                $this->abortResultCache();
            }
            $this->getResult();
            $this->includeComponentTemplate();
        }


        $this->application->SetTitle("Разделов - ". $this->arResult["COUNT"]);
    }
}