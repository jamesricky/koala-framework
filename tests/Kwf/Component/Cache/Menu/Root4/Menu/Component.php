<?php
class Kwf_Component_Cache_Menu_Root4_Menu_Component extends Kwc_Menu_Expanded_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['level'] = 2;
        //$ret['generators']['subMenu']['component'] = 'Kwf_Component_Cache_Menu_Root4_Menu_Sub_Component';
        return $ret;
    }
}
