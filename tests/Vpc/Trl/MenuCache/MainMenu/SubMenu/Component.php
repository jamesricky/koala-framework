<?php
class Vpc_Trl_MenuCache_MainMenu_SubMenu_Component extends Vpc_Menu_Component
{
    public static function getSettings()
    {
        $ret = parent::getSettings();
        $ret['level'] = 2;
        $ret['cssClass'] .= ' webListNone';
        return $ret;
    }
}