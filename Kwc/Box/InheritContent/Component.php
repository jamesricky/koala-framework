<?php
class Kwc_Box_InheritContent_Component extends Kwc_Abstract
{
    public static function getSettings()
    {
        $ret = parent::getSettings();
        $ret['generators']['child'] = array(
            'class' => 'Kwf_Component_Generator_Static',
            'component' => false
        );
        $ret['editComponents'] = array('child');

        $ret['extConfig'] = 'Kwf_Component_Abstract_ExtConfig_None';
        return $ret;
    }

    public function getTemplateVars()
    {
        $ret = parent::getTemplateVars();
        $ret['child'] = $this->getContentChild();
        return $ret;
    }

    public function getExportData()
    {
        return $this->getContentChild()->getComponent()->getExportData();
    }

    public function getContentChild()
    {
        $page = $this->getData();
        $ids = array();
        while ($page && !$page->inherits) {
            $ids[] = $page->id;
            $page = $page->parent;
            if ($page instanceof Kwf_Component_Data_Root) break;
        }
        $ids = array_reverse($ids);
        $page = $this->getData();
        do {
            while ($page && !$page->inherits) {
                $page = $page->parent;
                if ($page instanceof Kwf_Component_Data_Root) break;
            }
            $ic = $page;
            foreach ($ids as $id) {
                $ic = $ic->getChildComponent('-'.$id);
                if (!$ic) {
                    return null;
                }
            }
            $c = $ic->getChildComponent(array('generator' => 'child'));
            if (!$c) break; //box wurde überschrieben
            if ($page instanceof Kwf_Component_Data_Root) break;
            $page = $page->parent;
        } while(!$c->hasContent());
        return $c;
    }

    public function hasContent()
    {
        $c = $this->getContentChild();
        if (!$c) return false;
        return $c->hasContent();
    }
}