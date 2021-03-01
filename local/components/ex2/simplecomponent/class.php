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
                    "GROUP_PERM.GROUP_ID" => $this->getNumberGroupUser(),
                    ),
            'runtime' => [
                (new Bitrix\Main\ORM\Fields\Relations\Reference('GROUP_PERM', \Bitrix\Iblock\IblockGroupTable::class,
                    Bitrix\Main\ORM\Query\Join::on('this.IBLOCK_ID', 'ref.IBLOCK_ID')))
                ->configureJoinType('inner')
            ]
            ));


            while ($arElement = $rsElements->fetch()) {
             array_push($arClassif,$arElement);
             array_push($arClassifId,$arElement["ID"]);
            }


        $rsElements = Bitrix\Iblock\ElementPropertyTable::getList(array(
            'select' => array(
                "ELEMENT.NAME",
                "PROPERTY_TBL1.NAME",
               "VALUE",
//                "IBLOCK_PROPERTY_ID",
            ),
            'filter' => array(
//                "VALUE" => $arClassifId ,
                "PROPERTY_TBL1.IBLOCK_ID" => $this->arParams["PRODUCTS_IBLOCK_ID"],

                "PROPERTY_TBL1.ACTIVE" => "Y",
                "GROUP_PERM.PERMISSION" => ["R", "X", "W"],
                "GROUP_PERM.GROUP_ID" => $this->getNumberGroupUser(),
           ),
            'runtime' => [
                (new Bitrix\Main\ORM\Fields\Relations\Reference('PROPERTY_TBL1', \Bitrix\Iblock\PropertyTable::class,
                    Bitrix\Main\ORM\Query\Join::on('this.IBLOCK_PROPERTY_ID', 'ref.ID')))
                    ->configureJoinType('inner'),
                (new Bitrix\Main\ORM\Fields\Relations\Reference('GROUP_PERM', \Bitrix\Iblock\IblockGroupTable::class,
                    Bitrix\Main\ORM\Query\Join::on('this.PROPERTY_TBL1.IBLOCK_ID', 'ref.IBLOCK_ID')))
                    ->configureJoinType('inner')
                ]
       ));


        while ($rsEl = $rsElements->fetch())
        {
            $result[] = $rsEl;

            foreach ($arClassif as $key => $value)
            {
              echo "<pre>"; print_r( $value["ID"]); echo "</pre>";
                if ($value["ID"] == $rsEl["VALUE"])
                {
//
                }
            }
        }


        $iblock = \Bitrix\Iblock\Iblock::wakeUp($this->arParams["PRODUCTS_IBLOCK_ID"]);
        $elements = $iblock->getEntityDataClass()::getList([
            'select' => ['NAME']
        ])->fetchCollection();

        foreach ($elements as $element)
        {
//            echo "<pre>"; print_r($element->getName()); echo "</pre>";
        }




            $this->arResult["COUNT"] = count($arClassif);
            $this->arResult["CLASSIF"] = $arClassif;
            $this->SetResultCacheKeys(array("COUNT"));
    }

    public function getNumberGroupUser ()
    {
        return current(explode(",", $this->user->GetGroups()));
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