<?php
define('_JEXEC', 1);
define('JPATH_BASE', realpath('../../'));

require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';
require_once dirname(__FILE__) . '/helper.php';
require_once dirname(__FILE__) . '/validator.php';
require_once dirname(__FILE__) . '/recaptcha.php';

$helper = new ModDjmitryFormHelper();
$app = JFactory::getApplication('site');
$task = $app->input->getCmd('task');

if ($task == 'send') {
    $result = $helper->execute();
	echo json_encode($result);
} else if ($task == 'getToken') {
    $helper->getToken();
} else {
    throw new Exception('Wrong task');
}