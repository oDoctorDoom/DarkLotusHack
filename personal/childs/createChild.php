<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Bitrix\Main\Loader;

Loader::includeModule("highloadblock");

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

$hlblock = HL\HighloadBlockTable::getById(4)->fetch();

$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();
if($_REQUEST['end-date']!='' and $_REQUEST['end-date']!=null){
    $endDate='годен до'.$_REQUEST['end-date'].' ';
}else{
    $endDate=' ';
}
// Массив полей для добавления
$data = array(
    "UF_CITIZENSHIP_CH"=>$_REQUEST['citizenship'],
    "UF_FIO_CHILD"=>$_REQUEST['FIO'],
    "UF_DATE_BORN_CH"=>date("d.m.Y",strtotime($_REQUEST['date_born'])),
    'UF_DOCUMENT_TYPE_CH' =>$_REQUEST['type_document'],
    "UF_DOCUMENT_INFO"=>'Серия:'.$_REQUEST['serial_item'].' номер: '.$_REQUEST['number_doc'].' дата выдачи:'.$_REQUEST['date_out']
    .$endDate.'выдан: '.$_REQUEST['out_by'],
    "UF_REGISTRATION_CHILD"=>'Индекс: '.$_REQUEST['index_registr'].' Страна регистрации: '.$_REQUEST['country_registr'].' Регион регистрации: '.$_REQUEST['region_registr']
    .' район: '.$_REQUEST['district_registr'].' улица: '.$_REQUEST['street_registr'].' дом: '.$_REQUEST['home_registr'].' корпус: '.$_REQUEST['corpus_registr'].' квартира: '.$_REQUEST['float_registr'],
    "UF_FACT_LIVE"=>'Индекс: '.$_REQUEST['index_fact'].' Страна: '.$_REQUEST['country_fact'].' Регион: '.$_REQUEST['region_fact']
    .' район: '.$_REQUEST['district_fact'].' улица: '.$_REQUEST['street_fact'].' дом: '.$_REQUEST['home_fact'].' корпус: '.$_REQUEST['corpus_fact'].' квартира: '.$_REQUEST['float_fact'],

    'UF_SNILS_CHILD' =>$_REQUEST['snils'],
    'UF_NUMBER_PHONE_CHILD' =>$_REQUEST['number_phone'],
);

$result = $entity_data_class::add($data);
$dbUser = \Bitrix\Main\UserTable::getList(array(
    'select' => array('ID','UF_CHILD_ID' ),
    'filter' => array($USER->GetID())
))->fetch();

array_push($dbUser['UF_CHILD_ID'],$result->getId());

$USER->update($dbUser['ID'],array('UF_CHILD_ID'=>$dbUser['UF_CHILD_ID']));
header("Location: http://localhost/personal/childs/");
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

