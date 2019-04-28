<?php

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('script', JUri::root(). 'modules/mod_djmitry_form/assets/js/admin-script.js', ['version' => 'auto', 'relative' => true]);
HTMLHelper::_('stylesheet', JUri::root(). 'modules/mod_djmitry_form/assets/css/admin-style.css', ['version' => 'auto', 'relative' => true]);

/*
class JFormFieldAssets extends Joomla\CMS\Form\FormField
{
    protected $type = 'Assets';

    public function __construct($form = null){
        echo 111111111111;
        JHtml::script(JUri::root().'media/mod_simpleform2/js/simpleform2.js');
        return parent::__construct($form);
    }

    protected function getLabel()
    {
        return;
    }

    protected function getInput()
    {
        JHtml::script(JUri::root().'media/mod_simpleform2/js/simpleform2.js');
        HTMLHelper::_('script', 'mod_djmitry_form/js/admin-script.js', ['version' => 'auto', 'relative' => true]);
        HTMLHelper::_('stylesheet', 'mod_djmitry_form/css/admin-style.css', ['version' => 'auto', 'relative' => true]);
        // Custom HTML
        $html = '<p>Hello</p>';
        return $html;
    }
}*/