<?php
class Vps_Component_View_Helper_Partials extends Vps_Component_View_Renderer
{
    public function partials($component, $params = array())
    {
        if (!$component instanceof Vps_Component_Data ||
            !method_exists($component->getComponent(), 'getPartialVars')
        ) throw new Vps_Exception('Component has to implement Vps_Component_Partial_Interface');
        $partialClass = $component->getComponent()->getPartialClass();
        if (method_exists($component->getComponent(), 'getPartialParams')) {
            $params = array_merge($component->getComponent()->getPartialParams(), $params);
        }
        $config = array(
            'class' => $partialClass,
            'params' => $params
        );
        return $this->_getRenderPlaceholder($component->componentId, $config);
    }

    public function render($componentId, $config)
    {
        $partialClass = $config['class'];
        $params = $config['params'];
        $partial = new $partialClass($params);
        $ids = $partial->getIds();
        $number = 0; $count = count($ids);
        $ret = '';
        foreach ($ids as $id) {
            $config = array(
                'id' => $id,
                'class' => $partialClass,
                'params' => $params,
                'info' => array(
                    'total' => $count,
                    'number' => $number++,
                )
            );
            $type = 'partial';
            $renderer = $this->_getRenderer();
            if ($renderer instanceof Vps_Component_Renderer_Mail) {
                $type = 'mailPartial';
                $config['type'] = $renderer->getRenderFormat();
            }
            $ret .= $this->_getRenderPlaceholder($componentId, $config, $id, $type);
        }
        return $ret;
    }

    public function saveCache($componentId, $config, $value, $content) {
        return parent::saveCache($componentId, $config, null, Vps_Component_Cache::NO_CACHE);
    }
}