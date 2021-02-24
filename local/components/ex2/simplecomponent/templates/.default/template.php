<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?php if (count($arResult["CLASSIF"]) > 0) {?>
    <ul>
        <? foreach ($arResult["CLASSIF"] as $arClassificator) {?>
        <li>
            <b>
                <?= $arClassificator["NAME"];?>
            </b>
                <ul>
                    <?foreach ($arClassificator as  $arElem) {?>
                        <? if (is_array($arElem)) {?>
                            <li>
                                <?=$arElem["NAME"]; ?>
                                <?=$arElem["PROPERTY_PRICE_VALUE"]; ?>
                                <?=$arElem["PROPERTY_MATERIAL_VALUE"]; ?>
                                <?=$arElem["PROPERTY_ARTNUMBER_VALUE"]; ?>
                                <a href="<?=$arElem["DETAIL_PAGE_URL"];?>">ссылка</a>
                            </li>
                        <?}?>
                    <?}?>
                </ul>
        </li>
        <?}?>
    </ul>
<?}?>

