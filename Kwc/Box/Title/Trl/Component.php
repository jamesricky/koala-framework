<?php
class Kwc_Box_Title_Trl_Component extends Kwc_Chained_Trl_Component
{
    public static function getSettings($masterComponentClass = null)
    {
        $ret = parent::getSettings($masterComponentClass);
        $ret['flags']['hasInjectIntoRenderedHtml'] = true;
        return $ret;
    }

    public function injectIntoRenderedHtml($html)
    {
        return Kwc_Box_Title_Component::injectTitle($html, $this->getData()->render());
    }
}
