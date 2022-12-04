<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

if ($arParams['SHOW_PRIVATE_PAGE'] !== 'Y' && $arParams['USE_PRIVATE_PAGE_TO_AUTH'] !== 'Y')
{
	LocalRedirect($arParams['SEF_FOLDER']);
}

if ($arParams["MAIN_CHAIN_NAME"] <> '')
{
	$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}
$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_PRIVATE"));
if ($arParams['SET_TITLE'] == 'Y')
{
	$APPLICATION->SetTitle(Loc::getMessage("SPS_TITLE_PRIVATE"));
}

if (!$USER->IsAuthorized() || $arResult['SHOW_LOGIN_FORM'] === 'Y')
{
	if ($arParams['USE_PRIVATE_PAGE_TO_AUTH'] !== 'Y')
	{
		ob_start();
		$APPLICATION->AuthForm('', false, false, 'N', false);
		$authForm = ob_get_clean();
	}
	else
	{
		if ($arResult['SHOW_FORGOT_PASSWORD_FORM'] === 'Y')
		{
			ob_start();
			$APPLICATION->IncludeComponent(
				'bitrix:main.auth.forgotpasswd',
				'.default',
				array(
					'AUTH_AUTH_URL' => $arResult['PATH_TO_PRIVATE'],
//					'AUTH_REGISTER_URL' => 'register.php',
				),
				false
			);
			$authForm = ob_get_clean();
		}
		elseif($arResult['SHOW_CHANGE_PASSWORD_FORM'] === 'Y')
		{
			ob_start();
			$APPLICATION->IncludeComponent(
				'bitrix:main.auth.changepasswd',
				'.default',
				array(
					'AUTH_AUTH_URL' => $arResult['PATH_TO_PRIVATE'],
//					'AUTH_REGISTER_URL' => 'register.php',
				),
				false
			);
			$authForm = ob_get_clean();
		}
		else
		{
			ob_start();
			$APPLICATION->IncludeComponent(
				'bitrix:main.auth.form',
				'.default',
				array(
					'AUTH_FORGOT_PASSWORD_URL' => $arResult['PATH_TO_PASSWORD_RESTORE'],
//					'AUTH_REGISTER_URL' => 'register.php',
					'AUTH_SUCCESS_URL' => $arResult['AUTH_SUCCESS_URL'],
					'DISABLE_SOCSERV_AUTH' => $arParams['DISABLE_SOCSERV_AUTH'],
				),
				false
			);
			$authForm = ob_get_clean();
		}
	}

	?>
	<div class="row">
		<?
		if ($arParams['USE_PRIVATE_PAGE_TO_AUTH'] !== 'Y')
		{
			?>
			<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
				<div class="alert alert-danger"><?=GetMessage("SPS_ACCESS_DENIED")?></div>
			</div>
			<?
		}
		?>
		<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
			<?=$authForm?>
		</div>
	</div>
	<?
}
else
{
	$APPLICATION->IncludeComponent(
		"bitrix:main.profile",
		"",
		Array(
			"SET_TITLE" =>$arParams["SET_TITLE"],
			"AJAX_MODE" => $arParams['AJAX_MODE_PRIVATE'],
			"SEND_INFO" => $arParams["SEND_INFO_PRIVATE"],
			"CHECK_RIGHTS" => $arParams['CHECK_RIGHTS_PRIVATE'],
			"EDITABLE_EXTERNAL_AUTH_ID" => $arParams['EDITABLE_EXTERNAL_AUTH_ID'],
			"DISABLE_SOCSERV_AUTH" => $arParams['DISABLE_SOCSERV_AUTH']
		),
		$component
	);
    $dbUser = \Bitrix\Main\UserTable::getList(array(
        'select' => array('ID', 'NAME','UF_*' ),
        'filter' => array($USER->GetID())
    ))->fetch();
    ?>
    <table class="bx-soa-section-content child"  id="js-child-new">
        <form  method="post">
            <tr class="basket-item child status_parent"><td>Статус: </td><td><input type="text" class="type-parent" name="type_parent" list="types-parent" value="<?=$dbUser['UF_STATUS_USER']?>"></td></tr>
            <datalist id="types-parent">
                <option value="Родитель">
                <option value="Законный представитель">

            </datalist> </td></tr>
            <tr class="basket-item child citizenship"><td>Гражданство: </td><td><input required pattern="^[А-Яа-яЁё\s]+$" placeholder="Российская федерация" name="citizenship" type="text" value="<?=$dbUser['UF_CITIZENSHIP']?>"></td></tr>
            <tr class="basket-item child fio"><td>ФИО: </td><td><input required pattern="^[А-Яа-яЁё\s]+$" placeholder="Иванов Иван Иванович" name="FIO" type="text" value="<?=$dbUser['UF_FIO_PARENT']?>"> </td></tr>
            <tr class="basket-item child date-born"><td>Дата рождения: </td><td><input required pattern="[0-9]{2}.[0-9]{2}.[0-9]{4}" placeholder="10.02.2001" name="date_born" type="text" value="<?=$dbUser['UF_DATE_BORN']->toString()?>"> </td> </tr>
            <tr class="basket-item child type-document"><td>Тип документа: </td><td><input type="text" class="type-document" name="type_document" list="types-document" value="<?=$dbUser[ 'UF_DOCUMENT_TYPE']?>">
                    <datalist id="types-document">
                        <option value="Паспорт гражданина РФ">
                        <option value="Паспорт гражданина другой страны">

                    </datalist> </td></tr>
            <tr class="basket-item child info-pasport"><td>Информация документа: </td><td class="info-pasport container"><!--ВВод данных через js--></td></tr>
            <tr><td>Серия документа:</td><td><input required  placeholder="4444" name="serial_item" type="text" value="<?=$dbUser['UF_SERIAL_PASPORT']?>"> </td></tr>
            <tr><td>Номер документа:</td><td><input required  placeholder="444444" name="number_doc" type="text" value="<?=$dbUser['UF_NUMBER_PASPORT']?>"></td></tr>
            <tr><td>Дата выдачи документа:</td><td><input required pattern="[0-9]{2}.[0-9]{2}.[0-9]{4}" placeholder="01.01.2022" name="date_out" type="text" value="<?=$dbUser['UF_DATE_OUT_PASPORT']?>"></td></tr>
            <tr><td>Срок действия:</td><td><input  pattern="[0-9]{2}.[0-9]{2}.[0-9]{4}" placeholder="01.01.2022 или оставьте поле пустым" name="end_date" type="text"></td></tr>
            <tr><td>Кем выдан:</td><td><input  pattern="^[А-Яа-яЁё\s]+$" placeholder="" name="out_by" type="text"  value="<?=$dbUser['UF_OUT_BY']?>"></td></tr>

            <tr class="basket-item child registration-pasport"><td>Место регистрации: </td><td></td> </tr>
            <tr><td>Индекс:</td><td><input required pattern="[0-9]{6}" placeholder="444444" name="index_registr" type="text" value="<?=$dbUser['UF_INDEX']?>"> </td></tr>
            <tr><td>Страна:</td><td><input required pattern="^[А-Яа-яЁё\s]+$" placeholder="Российская федерация" name="country_registr" type="text" value="<?=$dbUser['UF_COUNTRY']?>"></td></tr>
            <tr><td>Регион:</td><td><input required pattern="^[А-Яа-яЁё\s]+$" placeholder="Оренбургская область" name="region_registr" type="text" value="<?=$dbUser['UF_REGION']?>"></td></tr>
            <tr><td>Район:</td><td><input  pattern="^[А-Яа-яЁё\s]+$" placeholder="Ленинский район" name="district_registr" type="text" value="<?=$dbUser['UF_DISTRICT']?>"></td></tr>
            <tr><td>Улица:</td><td><input required pattern="^[А-Яа-яЁё\s]+$" placeholder="Ленинского комсомола" name="street_registr" type="text" value="<?=$dbUser['UF_STREET']?>"></td></tr>
            <tr><td>Номер дома:</td><td><input required placeholder="1" name="home_registr" type="text" value="<?=$dbUser['UF_BUILD']?>"></td></tr>
            <tr><td>Корпус:</td><td><input  placeholder="2" name="corpus_registr" type="text" value="<?=$dbUser['UF_CORPUS']?>"></td></tr>
            <tr><td>Квартира:</td><td><input  placeholder="2" name="float_registr" type="text" value="<?=$dbUser['UF_FLAT']?>"></td></tr>
            <tr class="basket-item child snils"><td>СНИЛС: </td><td><input required pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}.[0-9]{2}" placeholder="XXX-XXX-XXX XX" name="snils" type="text" value="<?=$dbUser['UF_SNILS']?>"></td></tr>
            <tr class="basket-item child number-phone"><td>Номер телефона: </td><td><input  placeholder="+799999999" name="number_phone" type="tel" value="<?=$dbUser['UF_NUMBER_PHONE']?>"></td> </tr>
            <tr class="basket-item child number-phone"><td><input type="submit" value="Сохранить"></td> <td></td> </tr>
        </form>
    </table>
    <?
    if($_REQUEST['citizenship']){
        if($_REQUEST['type_parent']=='Родитель'){
            $_REQUEST['type_parent']=1;
        }else{
            $_REQUEST['type_parent']=2;
        }
        if($_REQUEST['type_document']=='Паспорт гражданина РФ'){
            $_REQUEST['type_document']=3;
        }else{
            $_REQUEST['type_document']=4;
        }
        $_REQUEST['country_registr']=5;

        $data=array(
            'UF_STATUS_USER'=>$_REQUEST['type_parent'],
            "UF_CITIZENSHIP"=>$_REQUEST['citizenship'],
            "UF_FIO_PARENT"=>$_REQUEST['FIO'],
            "UF_DATE_BORN"=>date("d.m.Y",strtotime($_REQUEST['date_born'])),
            'UF_DOCUMENT_TYPE' =>$_REQUEST['type_document'],
            'UF_SERIAL_PASPORT'=>$_REQUEST['serial_item'],
            'UF_NUMBER_PASPORT'=>$_REQUEST['number_doc'],
            "UF_DATE_OUT_PASPORT"=>date("d.m.Y",strtotime($_REQUEST['date_out'])),
            'UF_OUT_BY'=>$_REQUEST['out_by'],
            'UF_INDEX'=>$_REQUEST['index_registr'],
            'UF_COUNTRY'=>$_REQUEST['country_registr'],
            'UF_REGION'=>7,
            'UF_DISTRICT'=>$_REQUEST['district_registr'],
            'UF_STREET'=>$_REQUEST['street_registr'],
            'UF_BUILD'=>$_REQUEST['home_registr'],
            'UF_CORPUS'=>$_REQUEST['corpus_registr'],
            	'UF_FLAT'=>$_REQUEST['float_registr'],
            'UF_SNILS'=>$_REQUEST['snils'],
            'UF_NUMBER_PHONE'=>$_REQUEST['number_phone'],
        );
        $USER->update($USER->getId(),$data);
    }
}
