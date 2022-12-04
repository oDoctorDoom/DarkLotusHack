<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Редактирование карточек ребенка");

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Highloadblock\HighloadBlockTable;
#


CModule::IncludeModule('highloadblock');
$dbUser = \Bitrix\Main\UserTable::getList(array(
    'select' => array('ID', 'NAME','UF_*' ),
    'filter' => array($USER->GetID())
))->fetch();
echo '<pre>';


$hlblock = HighloadBlockTable::getById(4)->fetch();
$entity = HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();
$rsData = $entity_data_class::getList(array(
    'filter' => array('ID' => $dbUser['UF_CHILD_ID'])
))->fetchAll();

echo '</pre>';
$APPLICATION->SetAdditionalCSS('/personal/childs/style.css');

?>

<div class="select-child-wrap">
    <form>
        <?
        foreach ($dbUser['UF_CHILD_ID'] as $key=>$child){?>
            <input  class="child" name="child" type="radio" id="child-<?=$key?> " value="<?=$key?>" onclick="display(<?=$key?>)">
            <label for="child-<?=$key?>"><?=$rsData[$key]['UF_FIO_CHILD']?></label>
        <?}?>
        <input  class="child" name="child" type="radio" id="child-new " value="new" onclick="display('new')">
        <label for="child-new?>">Новая анкета</label>
    </form>

</div>
<?foreach ($dbUser['UF_CHILD_ID'] as $key=>$child){?>
    <form>
    <table class="bx-soa-section-content child"  id="js-child-<?=$key?>">
        <tr class="basket-item child citizenship"><td>Гражданство: </td><td><?=$rsData[$key]['UF_CITIZENSHIP_CH']?></td></tr>
        <tr class="basket-item child fio"><td>ФИО: </td><td><?=$rsData[$key]['UF_FIO_CHILD']?> </td></tr>
        <tr class="basket-item child date-born"><td>Дата рождения: </td><td><?=$rsData[$key]['UF_DATE_BORN_CH']->toString()?></td> </tr>
        <tr class="basket-item child type-document"><td>Тип документа: </td><td><?=$rsData[$key]['UF_DOCUMENT_TYPE_CH']?> </td></tr>
        <tr class="basket-item child info-pasport"><td>Информация документа: </td><td><?=$rsData[$key]['UF_DOCUMENT_INFO']?> </td></tr>
        <tr class="basket-item child registration-pasport"><td>Место регистрации: </td><td><?=$rsData[$key]['UF_REGISTRATION_CHILD']?></td> </tr>
        <tr class="basket-item child fact-live"><td>Фактическое место проживания: </td><td><?=$rsData[$key]['UF_FACT_LIVE']?> </td></tr>
        <tr class="basket-item child snils"><td>СНИЛС: </td><td><?=$rsData[$key]['UF_SNILS_CHILD']?> </td></tr>
        <tr class="basket-item child number-phone"><td>Номер телефона: </td><td><?=$rsData[$key]['UF_NUMBER_PHONE_CHILD']?></td> </tr>
        <tr class="basket-item child number-phone"><td><input type="submit" value="Сохранить"></td> <td></td> </tr>
    </form>
    </table>
<?}?>

<table class="bx-soa-section-content child"  id="js-child-new">
    <form action="createChild.php" method="post">
        <input hidden type="text" name="id_parent" value="<?=$USER->GetID()?>">
    <tr class="basket-item child citizenship"><td>Гражданство: </td><td><input required pattern="^[А-Яа-яЁё\s]+$" placeholder="Российская федерация" name="citizenship" type="text"></td></tr>
    <tr class="basket-item child fio"><td>ФИО: </td><td><input required pattern="^[А-Яа-яЁё\s]+$" placeholder="Иванов Иван Иванович" name="FIO" type="text"> </td></tr>
    <tr class="basket-item child date-born"><td>Дата рождения: </td><td><input required pattern="[0-9]{2}.[0-9]{2}.[0-9]{4}" placeholder="10.02.2001" name="date_born" type="text"> </td> </tr>
    <tr class="basket-item child type-document"><td>Тип документа: </td><td><input type="text" class="type-document" name="type_document" list="types-document" onchange="generateInputs(this)">
            <datalist id="types-document">
                <option value="Свидетельство о рождении РФ">
                <option value="Свидетельство о рождении другой страны">
                <option value="Паспорт гражданина РФ">
                <option value="Паспорт гражданина другой страны">

            </datalist> </td></tr>
    <tr class="basket-item child info-pasport"><td>Информация документа: </td><td class="info-pasport container"><!--ВВод данных через js--></td></tr>
    <tr><td>Серия документа:</td><td><input required  placeholder="4444" name="serial_item" type="text"> </td></tr>
    <tr><td>Номер документа:</td><td><input required  placeholder="444444" name="number_doc" type="text"></td></tr>
    <tr><td>Дата выдачи документа:</td><td><input required pattern="[0-9]{2}.[0-9]{2}.[0-9]{4}" placeholder="01.01.2022" name="date_out" type="text"></td></tr>
    <tr><td>Срок действия:</td><td><input  pattern="[0-9]{2}.[0-9]{2}.[0-9]{4}" placeholder="01.01.2022 или оставьте поле пустым" name="end_date" type="text"></td></tr>
    <tr><td>Кем выдан:</td><td><input  pattern="^[А-Яа-яЁё\s]+$" placeholder="" name="out_by" type="text"></td></tr>

    <tr class="basket-item child registration-pasport"><td>Место регистрации: </td><td></td> </tr>
        <tr><td>Индекс:</td><td><input required pattern="[0-9]{6}" placeholder="444444" name="index_registr" type="text"> </td></tr>
        <tr><td>Страна:</td><td><input required pattern="^[А-Яа-яЁё\s]+$" placeholder="Российская федерация" name="country_registr" type="text"></td></tr>
        <tr><td>Регион:</td><td><input required pattern="^[А-Яа-яЁё\s]+$" placeholder="Оренбургская область" name="region_registr" type="text"></td></tr>
        <tr><td>Район:</td><td><input  pattern="^[А-Яа-яЁё\s]+$" placeholder="Ленинский район" name="district_registr" type="text"></td></tr>
        <tr><td>Улица:</td><td><input required pattern="^[А-Яа-яЁё\s]+$" placeholder="Ленинского комсомола" name="street_registr" type="text"></td></tr>
        <tr><td>Номер дома:</td><td><input required placeholder="1" name="home_registr" type="text"></td></tr>
        <tr><td>Корпус:</td><td><input  placeholder="2" name="corpus_registr" type="text"></td></tr>
        <tr><td>Квартира:</td><td><input  placeholder="2" name="float_registr" type="text"></td></tr>
    <tr class="basket-item child fact-live"><td>Фактическое место проживания: </td><td></td></tr>
        <tr><td>Индекс:</td><td><input required pattern="[0-9]{6}" placeholder="444444" name="index_fact" type="text"> </td></tr>
        <tr><td>Страна:</td><td><input required pattern="^[А-Яа-яЁё\s]+$" placeholder="Российская федерация" name="country_fact" type="text"></td></tr>
        <tr><td>Регион:</td><td><input required pattern="^[А-Яа-яЁё\s]+$" placeholder="Оренбургская область" name="region_fact" type="text"></td></tr>
        <tr><td>Район:</td><td><input  pattern="^[А-Яа-яЁё\s]+$" placeholder="Ленинский район" name="district_fact" type="text"></td></tr>
        <tr><td>Улица:</td><td><input required pattern="^[А-Яа-яЁё\s]+$" placeholder="Ленинского комсомола" name="street_fact" type="text"></td></tr>
        <tr><td>Номер дома:</td><td><input required placeholder="1" name="home_fact" type="text"></td></tr>
        <tr><td>Корпус:</td><td><input  placeholder="2" name="corpus_fact" type="text"></td></tr>
        <tr><td>Квартира:</td><td><input  placeholder="2" name="float_fact" type="text"></td></tr>
    <tr class="basket-item child snils"><td>СНИЛС: </td><td><input required pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}.[0-9]{2}" placeholder="XXX-XXX-XXX XX" name="snils" type="text"></td></tr>
    <tr class="basket-item child number-phone"><td>Номер телефона: </td><td><input  placeholder="+799999999" name="number_phone" type="tel"></td> </tr>
    <tr class="basket-item child number-phone"><td><input type="submit" value="Сохранить"></td> <td></td> </tr>
</form>
</table>



<script src="script.js"></script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
