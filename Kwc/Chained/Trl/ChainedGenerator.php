<?php
class Kwc_Chained_Trl_ChainedGenerator extends Kwc_Chained_Abstract_ChainedGenerator
{
    protected $_addUrlPart = false;

    public function getPagesControllerConfig($component, $generatorClass = null)
    {
        $ret = parent::getPagesControllerConfig($component, $generatorClass);
        $ret['icon'] = 'plugin';
        return $ret;
    }

    protected function _init()
    {
        parent::_init();
    }

    protected function _formatSelect($parentData, $select)
    {
        $ret = parent::_formatSelect($parentData, $select);
        if (!$ret) return $ret;
        $ret->whereEquals('master', false);
        return $ret;
    }
}