<?php

defined('_JEXEC') or die;

$doc = JFactory::getDocument();
if (!$params->get('disable_css')) {
	$doc->addStyleSheet(JURI::root()."modules/mod_djmitry_form/assets/css/style.css");
}
$doc->addScript(JURI::root()."modules/mod_djmitry_form/assets/js/script.js");

/**
	$db = JFactory::getDBO();
	$db->setQuery("SELECT * FROM #__mod_djmitry_form where del=0 and module_id=".$module->id);
	$objects = $db->loadAssocList();
*/
require JModuleHelper::getLayoutPath('mod_djmitry_form', $params->get('layout', 'default'));