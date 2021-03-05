<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?php if (count($arResult["FIRM_CLASSIF"]) > 0) {?>
    <ul>
        <? foreach ($arResult["FIRM_CLASSIF"] as $id => $arClassificator) {?>
        <li>
            <b>
                <?= $arResult["CLASSIF"][$id]["NAME"];?>
            </b>
                <ul>
                    <?foreach ($arClassificator as  $arElem) {?>
                            <li>
                                <?=$arResult["ELEMENT_PROPERTY"][$arElem]["NAME"]; ?>
                                <?=$arResult["ELEMENT_PROPERTY"][$arElem]["PRICE"]; ?>
                                <?=$arResult["ELEMENT_PROPERTY"][$arElem]["MATERIAL"]; ?>
                                <?=$arResult["ELEMENT_PROPERTY"][$arElem]["ARTNUMBER"]; ?>
                                <a href="<?=$arResult["ELEMENT_PROPERTY"][$arElem]["DETAIL_URL"];?>">ссылка</a>
                            </li>
                    <?}?>
                </ul>
        </li>
        <?}?>
    </ul>
<?}?>

