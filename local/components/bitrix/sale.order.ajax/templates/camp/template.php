<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();



use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Highloadblock\HighloadBlockTable;
#

CModule::IncludeModule('highloadblock');
$dbUser = \Bitrix\Main\UserTable::getList(array(
    'select' => array('ID', 'NAME','UF_*' ),
    'filter' => array($arResult['PERSON_TYPE']['1']['ID'])
))->fetch();
echo '<pre>';
var_dump($dbUser);
$hlblock = HighloadBlockTable::getById(4)->fetch();
$entity = HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();
$rsData = $entity_data_class::getList(array(



    'filter' => array('ID' => $dbUser['UF_CHILD_ID'][0])
))->fetch();
var_dump($rsData);
echo '</pre>';
?>

<?
#STEP ONE GET BASKET ITEM
?>
<? if ($arParams['BASKET_POSITION'] === 'before'): ?>
    <!--	BASKET ITEMS BLOCK	-->
    <div id="bx-soa-basket" data-visited="false" class="bx-soa-section bx-active">
        <div class="bx-soa-section-title-container d-flex justify-content-between align-items-center flex-nowrap">
            <div class="bx-soa-section-title" data-entity="section-title">
                <span class="bx-soa-section-title-count"></span>
                Лагерь
            </div>

        </div>
        <div class="bx-soa-section-content">
            <div class="basket-item-camp-name"><?=$arResult['BASKET_ITEMS'][0]['PREVIEW_TEXT']?></div>
            <div class="basket-item-shift-name"><?=$arResult['BASKET_ITEMS'][0]['NAME']?></div>
            <div class="basket-item-shift-price"><?=$arResult['BASKET_ITEMS'][0]['SUM_BASE_FORMATED']?> </div>
            <div class="basket-item-camp-pic"><img src="<?=$arResult['BASKET_ITEMS'][0]['PREVIEW_PICTURE_SRC']?>"></div>
            <div class="basket-item-camp-prop wrap">
                <?foreach ($arResult['BASKET_ITEMS'][0]['PROPS'] as $prop){?>
                    <div class="basket-item-camp-prop">
                        <div class="basket-item-camp-prop prop-name"><?=$prop['NAME']?></div>
                        <div class="basket-item-camp-prop prop-value"><?=$prop['VALUE']?></div>

                    </div>
                <?}?>
            </div>
        </div>
    </div>
<? endif ?>

<?
#STEP TWO GET USER
?>


<?
#STEP THREE GET CHILD
?>

<?
#BUTN MAKE ORDER
?>
