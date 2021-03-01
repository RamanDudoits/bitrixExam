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
                                <?=$arElem["PRICE"]; ?>
                                <?=$arElem["MATERIAL"]; ?>
                                <?=$arElem["ARTNUMBER"]; ?>
                                <a href="<?=$arElem["DETAIL_URL"];?>">ссылка</a>
                            </li>
                        <?}?>
                    <?}?>
                </ul>
        </li>
        <?}?>
    </ul>
<?}?>

