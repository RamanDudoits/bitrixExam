<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?php if (count($arResult["CLASSIF"]) > 0) {?>
    <ul>
        <? foreach ($arResult["CLASSIF"] as $arClassificator) {?>
        <li>
            <b>
                <?= $arClassificator["NAME"];?>
            </b>
            <?if (count($arClassificator["ELEMENTS"]) > 0) {?>
                <ul>
                    <?foreach ($arClassificator["ELEMENTS"] as $arItems) {?>
                    <li>
                        <?=$arItems["NAME"]; ?>
                        <?=$arItems["PROPERTY"]["PRICE"]["VALUE"]; ?>
                        <?=$arItems["PROPERTY"]["MATERIAL"]["VALUE"]; ?>
                        <?=$arItems["PROPERTY"]["ARTNUMBER"]["VALUE"]; ?>
                        <a href="<?=$arItems["DETAIL_PAGE_URL"];?>">ссылка</a>
                    </li>
                    <?}?>
                </ul>
            <?}?>
        </li>
        <?}?>
    </ul>
<?}?>


