<?php
class Kwc_Abstract_List_Component extends Kwc_Abstract
{
    public static function getSettings($param = null)
    {
        $ret = array_merge(parent::getSettings($param), array(
            'componentName' => 'List',
            'childModel'     => 'Kwc_Abstract_List_Model',
            'ownModel'     => 'Kwc_Abstract_List_OwnModel',
        ));
        $ret['generators']['child'] = array(
            'class' => 'Kwc_Abstract_List_Generator',
            'component' => null
        );
        $ret['assetsAdmin']['dep'][] = 'KwfProxyPanel';
        $ret['assetsAdmin']['dep'][] = 'KwfAutoGrid';
        $ret['assetsAdmin']['dep'][] = 'KwfMultiFileUploadPanel';
        $ret['assetsAdmin']['files'][] = 'kwf/Kwc/Abstract/List/EditButton.js';
        $ret['assetsAdmin']['files'][] = 'kwf/Kwc/Abstract/List/PanelWithEditButton.js';
        $ret['assetsAdmin']['files'][] = 'kwf/Kwc/Abstract/List/List.js';
        $ret['assetsAdmin']['files'][] = 'kwf/Kwc/Abstract/List/ListEditButton.js';
        $ret['extConfig'] = 'Kwc_Abstract_List_ExtConfigListUpload';
        $ret['hasVisible'] = true;
        $ret['defaultVisible'] = false;
        $ret['maxEntries'] = 100;
        return $ret;
    }

    public static function validateSettings($settings, $componentClass)
    {
        if (isset($settings['default'])) {
            throw new Kwf_Exception("Setting default doesn't exist anymore");
        }
    }

    // For trl
    public final function getSelect()
    {
        return $this->_getSelect();
    }

    //kann überschrieben werden um zB ein limit einzubauen
    protected function _getSelect()
    {
        $select = new Kwf_Component_Select();
        $select->whereGenerator('child');
        return $select;
    }

    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $ret = parent::getTemplateVars($renderer);
        $children = $this->getData()->getChildComponents($this->getSelect());

        // children ist die alte methode, bleibt drin wegen kompatibilität
        $ret['children'] = $children;

        // das hier ist die neue variante und ist besser, weil man leichter mehr daten
        // zurückgeben kann, bzw. in der übersetzung überschreiben kann
        // zB: Breite bei übersetzung von Columns
        $ret['listItems'] = array();
        $i = 0;
        foreach ($children as $child) {
            $class = $this->_getBemClass('listItem', 'listItem').' ';
            if ($i == 0) $class .= ' '.$this->_getBemClass('listItem--first', 'kwcFirst');
            if ($i == count($children)-1) $class .= ' '.$this->_getBemClass('listItem--last', 'kwcLast');
            if ($i % 2 == 0) {
                $class .= ' '.$this->_getBemClass('listItem--even', 'kwcEven');
            } else {
                $class .= ' '.$this->_getBemClass('listItem--odd', 'kwcOdd');
            }
            $class = trim($class);
            $i++;

            $preHtml = '';
            $postHtml = '';
            foreach (Kwf_Component_Data_Root::getInstance()->getPlugins('Kwf_Component_PluginRoot_Interface_MaskComponent') as $plugin) {
                $mask = $plugin->getMaskCode($child);
                $preHtml = $mask['begin'] . $preHtml;
                $postHtml = $postHtml . $mask['end'];
            }

            $ret['listItems'][] = array(
                'data' => $this->getItemComponent($child),
                'class' => $class,
                'style' => '',
                'preHtml' => $preHtml,
                'postHtml' => $postHtml
            );
        }
        return $ret;
    }

    // For trl
    public final function getItemComponent($childComponent)
    {
        return $this->_getItemComponent($childComponent);
    }

    protected function _getItemComponent($childComponent)
    {
        return $childComponent;
    }

    public function getExportData()
    {
        $ret = array('list' => array());
        $children = $this->getData()->getChildComponents($this->_getSelect());
        foreach ($children as $child) {
            $ret['list'][] = $child->getComponent()->getExportData();
        }
        return $ret;
    }

    public function hasContent()
    {
        $childComponents = $this->getData()->getChildComponents($this->_getSelect());
        foreach ($childComponents as $c) {
            if ($c->hasContent()) return true;
        }
        return false;
    }
}
