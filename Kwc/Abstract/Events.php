<?php
class Kwc_Abstract_Events extends Kwf_Component_Abstract_Events
{
    public function getListeners()
    {
        $ret = array();
        if (Kwc_Abstract::hasSetting($this->_class, 'ownModel')) {
            $ret[] = array(
                'class' => Kwc_Abstract::getSetting($this->_class, 'ownModel'),
                'event' => 'Kwf_Component_Event_Row_Updated',
                'callback' => 'onOwnRowUpdate'
            );
            $ret[] = array(
                'class' => Kwc_Abstract::getSetting($this->_class, 'ownModel'),
                'event' => 'Kwf_Component_Event_Row_Inserted',
                'callback' => 'onOwnRowUpdate'
            );
        }
        return $ret;
    }

    public function onOwnRowUpdate(Kwf_Component_Event_Row_Abstract $event)
    {
        $this->fireEvent(new Kwf_Component_Event_Component_ContentChanged(
            $this->_class, $event->row->component_id
        ));
        if (Kwc_Abstract::hasSetting($this->_class, 'throwHasContentChangedOnRowColumnsUpdate')) {
            $columns = Kwc_Abstract::hasSetting($this->_class, 'throwHasContentChangedOnRowColumnsUpdate');
            if ($event->isDirty(Kwc_Abstract::getSetting($this->_class, 'throwHasContentChangedOnRowColumnsUpdate'))) {
                $this->fireEvent(new Kwf_Component_Event_Component_HasContentChanged(
                    $this->_class, $event->row->component_id
                ));
            }
        }
    }
}