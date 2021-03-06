<?php
class Kwf_Component_Generator_Plugin_Tags_Trl_Component extends Kwf_Component_Generator_Plugin_Abstract
{
    public static function getSettings($masterComponentClass = null)
    {
        $ret = parent::getSettings($masterComponentClass);
        $ret['componentName'] = trlKwfStatic('Tags Translation');
        $ret['componentIcon'] = 'tag_blue.png';
        $ret['menuConfig'] = 'Kwf_Component_Generator_Plugin_Tags_Trl_MenuConfig';
        return $ret;
    }
}
