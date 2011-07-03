<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->helper('progressor');
$this->load->helper('form');?>
<h2>Submit Answer</h2>
<?= eb_progress_bar($progressSteps) ?>
<h3>Card payment</h3>
<p>Required fields are bold.</p>
<?php
if($this->validation->error_string!='')$errors[] = $this->validation->error_string;
$this->load->view('chunks/messages_ajax',array('errors'=>@$errors));?>
<form action="<?=site_url('user/pay',true)?>" method="POST" id="card">
<?= form_fieldset('Card details') ?>
	<?= eb_input_text('name','Cardholder\'s name',array('value'=>@$this->validation->name,'class'=>'required','sublabel'=>'Enter exactly as written on card, with title if present')) ?>
	<?= eb_input_text('cardnum','Card number',
								array('id'=>'cardnum','value'=>@$this->validation->cardnum,'sublabel'=>'With or without spaces','class'=>'required')) ?>
	<?= eb_select('type','Card type',
							array('Maestro'=>'Maestro','MasterCard'=>'MasterCard','Solo'=>'Solo','Switch'=>'Switch','Visa'=>'Visa','VisaElectron'=>'Visa Electron'),
							array('id'=>'cardType','class'=>'required','value'=>@$this->validation->type)) ?>
	<?= eb_input_text('secCode','Security code',
								array('class'=>'required','value'=>@$this->validation->secCode,'sublabel'=>'Printed on the <a class="inline" href="'.app_base().'info/cardsecuritycode">back of your card</a>')) ?>
	<?= eb_input_text('issueStartDate','Issue number / Start date',
								array('value'=>@$this->validation->issueStartDate,'sublabel'=>' <a class="inline" href="'.app_base().'info/switchsolo">Switch/Solo</a> only. No issue number? Please enter start date (mm/yy)')) ?>
	<?= eb_date('expDate','Expiration date',array('class'=>'required','id'=>'test','MM'=>@$this->validation->expDateMM,'YYYY'=>@$this->validation->expDateYYYY)) ?>
<?= form_fieldset_close() ?>
<?= form_fieldset('Address') ?>
	<?= eb_input_text('address1','Adress line one',array('class'=>'required','value'=>@$this->validation->address1)) ?>
	<?= eb_input_text('address2','Adress line two',array('class'=>'required','value'=>@$this->validation->address2)) ?>
	<?= eb_input_text('town','Town, city, hamlet',array('class'=>'required','value'=>@$this->validation->town)) ?>
	<?= eb_input_text('county','County',array('class'=>'required','value'=>@$this->validation->county)) ?>
	<?= eb_input_text('postcode','Postcode',array('class'=>'required','value'=>@$this->validation->postcode)) ?>
	<?= eb_select('country','Country',
					array('AF'=>'AFGHANISTAN','AX'=>'ÅLAND ISLANDS','AL'=>'ALBANIA','DZ'=>'ALGERIA','AS'=>'AMERICAN SAMOA','AD'=>'ANDORRA','AO'=>'ANGOLA','AI'=>'ANGUILLA','AQ'=>'ANTARCTICA','AG'=>'ANTIGUA AND BAR­BUDA','AR'=>'ARGENTINA','AM'=>'ARMENIA','AW'=>'ARUBA','AU'=>'AUSTRALIA','AT'=>'AUSTRIA','AZ'=>'AZERBAIJAN','BS'=>'BAHAMAS','BH'=>'BAHRAIN','BD'=>'BANGLADESH','BB'=>'BARBADOS','BY'=>'BELARUS','BE'=>'BELGIUM','BZ'=>'BELIZE','BJ'=>'BENIN','BM'=>'BERMUDA','BT'=>'BHUTAN','BO'=>'BOLIVIA','BA'=>'BOSNIA AND HERZE­GOVINA','BW'=>'BOTSWANA','BV'=>'BOUVET ISLAND','BR'=>'BRAZIL','IO'=>'BRITISH INDIAN OCEAN TERRITORY','BN'=>'BRUNEI DARUSSALAM','BG'=>'BULGARIA','BF'=>'BURKINA FASO','BI'=>'BURUNDI','KH'=>'CAMBODIA','CM'=>'CAMEROON','CA'=>'CANADA','CV'=>'CAPE VERDE','KY'=>'CAYMAN ISLANDS','CF'=>'CENTRAL AFRICAN REPUBLIC','TD'=>'CHAD','CL'=>'CHILE','CN'=>'CHINA','CX'=>'CHRISTMAS ISLAND','CC'=>'COCOS (KEELING) ISLANDS','CO'=>'COLOMBIA','KM'=>'COMOROS','CG'=>'CONGO','CD'=>'CONGO, THE DEMO­CRATIC REPUBLIC OF THE','CK'=>'COOK ISLANDS','CR'=>'COSTA RICA','CI'=>'COTE D\'IVOIRE','HR'=>'CROATIA','CU'=>'CUBA','CY'=>'CYPRUS','CZ'=>'CZECH REPUBLIC','DK'=>'DENMARK','DJ'=>'DJIBOUTI','DM'=>'DOMINICA','DO'=>'DOMINICAN REPUBLIC','EC'=>'ECUADOR','EG'=>'EGYPT','SV'=>'EL SALVADOR','GQ'=>'EQUATORIAL GUINEA','ER'=>'ERITREA','EE'=>'ESTONIA','ET'=>'ETHIOPIA','FK'=>'FALKLAND ISLANDS (MALVINAS)','FO'=>'FAROE ISLANDS','FJ'=>'FIJI','FI'=>'FINLAND','FR'=>'FRANCE','GF'=>'FRENCH GUIANA','PF'=>'FRENCH POLYNESIA','TF'=>'FRENCH SOUTHERN TERRITORIES','GA'=>'GABON','GM'=>'GAMBIA','GE'=>'GEORGIA','DE'=>'GERMANY','GH'=>'GHANA','GI'=>'GIBRALTAR','GR'=>'GREECE','GL'=>'GREENLAND','GD'=>'GRENADA','GP'=>'GUADELOUPE','GU'=>'GUAM','GT'=>'GUATEMALA','GG'=>'GUERNSEY','GN'=>'GUINEA','GW'=>'GUINEA-BISSAU','GY'=>'GUYANA','HT'=>'HAITI','HM'=>'HEARD ISLAND AND MCDONALD ISLANDS','VA'=>'HOLY SEE (VATICAN CITY STATE)','HN'=>'HONDURAS','HK'=>'HONG KONG','HU'=>'HUNGARY','IS'=>'ICELAND','IN'=>'INDIA','ID'=>'INDONESIA','IR'=>'IRAN, ISLAMIC REPUB­LIC OF','IQ'=>'IRAQ','IE'=>'IRELAND','IM'=>'ISLE OF MAN','IL'=>'ISRAEL','IT'=>'ITALY','JM'=>'JAMAICA','JP'=>'JAPAN','JE'=>'JERSEY','JO'=>'JORDAN','KZ'=>'KAZAKHSTAN','KE'=>'KENYA','KI'=>'KIRIBATI','KP'=>'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF','KR'=>'KOREA, REPUBLIC OF','KW'=>'KUWAIT','KG'=>'KYRGYZSTAN','LA'=>'LAO PEOPLE\'S DEMO­CRATIC REPUBLIC','LV'=>'LATVIA','LB'=>'LEBANON','LS'=>'LESOTHO','LR'=>'LIBERIA','LY'=>'LIBYAN ARAB JAMA­HIRIYA','LI'=>'LIECHTENSTEIN','LT'=>'LITHUANIA','LU'=>'LUXEMBOURG','MO'=>'MACAO','MK'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','MG'=>'MADAGASCAR','MW'=>'MALAWI','MY'=>'MALAYSIA','MV'=>'MALDIVES','ML'=>'MALI','MT'=>'MALTA','MH'=>'MARSHALL ISLANDS','MQ'=>'MARTINIQUE','MR'=>'MAURITANIA','MU'=>'MAURITIUS','YT'=>'MAYOTTE','MX'=>'MEXICO','FM'=>'MICRONESIA, FEDER­ATED STATES OF','MD'=>'MOLDOVA, REPUBLIC OF','MC'=>'MONACO','MN'=>'MONGOLIA','MS'=>'MONTSERRAT','MA'=>'MOROCCO','MZ'=>'MOZAMBIQUE','MM'=>'MYANMAR','NA'=>'NAMIBIA','NR'=>'NAURU','NP'=>'NEPAL','NL'=>'NETHERLANDS','AN'=>'NETHERLANDS ANTI­LLES','NC'=>'NEW CALEDONIA','NZ'=>'NEW ZEALAND','NI'=>'NICARAGUA','NE'=>'NIGER','NG'=>'NIGERIA','NU'=>'NIUE','NF'=>'NORFOLK ISLAND','MP'=>'NORTHERN MARIANA ISLANDS','NO'=>'NORWAY','OM'=>'OMAN','PK'=>'PAKISTAN','PW'=>'PALAU','PS'=>'PALESTINIAN TERRI­TORY, OCCUPIED','PA'=>'PANAMA','PG'=>'PAPUA NEW GUINEA','PY'=>'PARAGUAY','PE'=>'PERU','PH'=>'PHILIPPINES','PN'=>'PITCAIRN','PL'=>'POLAND','PT'=>'PORTUGAL','PR'=>'PUERTO RICO','QA'=>'QATAR','RE'=>'REUNION','RO'=>'ROMANIA','RU'=>'RUSSIAN FEDERATION','RW'=>'RWANDA','SH'=>'SAINT HELENA','KN'=>'SAINT KITTS AND NEVIS','LC'=>'SAINT LUCIA','PM'=>'SAINT PIERRE AND MIQUELON','VC'=>'SAINT VINCENT AND THE GRENADINES','WS'=>'SAMOA','SM'=>'SAN MARINO','ST'=>'SAO TOME AND PRINC­IPE','SA'=>'SAUDI ARABIA','SN'=>'SENEGAL','CS'=>'SERBIA AND MON­TENEGRO','SC'=>'SEYCHELLES','SL'=>'SIERRA LEONE','SG'=>'SINGAPORE','SK'=>'SLOVAKIA','SI'=>'SLOVENIA','SB'=>'SOLOMON ISLANDS','SO'=>'SOMALIA','ZA'=>'SOUTH AFRICA','GS'=>'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS','ES'=>'SPAIN','LK'=>'SRI LANKA','SD'=>'SUDAN','SR'=>'SURINAME','SJ'=>'SVALBARD AND JAN MAYEN','SZ'=>'SWAZILAND','SE'=>'SWEDEN','CH'=>'SWITZERLAND','SY'=>'SYRIAN ARAB REPUB­LIC','TW'=>'TAIWAN, PROVINCE OF CHINA','TJ'=>'TAJIKISTAN','TZ'=>'TANZANIA, UNITED REPUBLIC OF','TH'=>'THAILAND','TL'=>'TIMOR-LESTE','TG'=>'TOGO','TK'=>'TOKELAU','TO'=>'TONGA','TT'=>'TRINIDAD AND TOBAGO','TN'=>'TUNISIA','TR'=>'TURKEY','TM'=>'TURKMENISTAN','TC'=>'TURKS AND CAICOS ISLANDS','TV'=>'TUVALU','UG'=>'UGANDA','UA'=>'UKRAINE','AE'=>'UNITED ARAB EMIR­ATES','GB'=>'UNITED KINGDOM','US'=>'UNITED STATES','UM'=>'UNITED STATES MINOR OUTLYING ISLANDS','UY'=>'URUGUAY','UZ'=>'UZBEKISTAN','VU'=>'VANUATU','VE'=>'VENEZUELA','VN'=>'VIET NAM','VG'=>'VIRGIN ISLANDS, BRIT­ISH','VI'=>'VIRGIN ISLANDS, U.S.','WF'=>'WALLIS AND FUTUNA','EH'=>'WESTERN SAHARA','YE'=>'YEMEN','ZM'=>'ZAMBIA','ZW'=>'ZIMBABWE'),
					array('class'=>'required','value'=>'GB'));?>
	<?= eb_input_text('phoneNum','Phone number',array('class'=>'required','value'=>@$this->validation->phoneNum)) ?>
<?= form_fieldset_close() ?>
<?= form_fieldset() ?>
	<?= eb_hidden('token',$token) ?>
	<?= eb_submit('card-submit'); ?>
<?= form_fieldset_close() ?>
</form>