<?
namespace XSite;

function HighLoadBlockGetList($HLBLOCK_ID, $params = []) {

	$ret = [];

	$default = [
		"filter" => [],
		"order" => ["ID"=>"DESC"],
		"select" => ["*"]
	];

	extract($default);
	extract($params);

	if (!\Bitrix\Main\Loader::IncludeModule("highloadblock")) return false;

	$hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById($HLBLOCK_ID)->fetch();
	$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
	$entityDataClass = $entity->getDataClass();
	$result = $entityDataClass::getList(array(
		"select" => $select,
		"order" => $order,
		"filter" => $filter,
	));
	
	while ($arRow = $result->Fetch()) {

		// by $retBy $params['retBy']
		switch ($retBy) {
			case "id": $ret[$arRow['ID']] = $arRow; break;
			case "xml_id": $ret[$arRow['UF_XML_ID']] = $arRow; break;
			default: $ret[] = $arRow; break;
		}
	
	}

	return $ret;

}