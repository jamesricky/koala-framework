<?php
class Kwf_Component_Cache_Meta_Static_Model extends Kwf_Component_Cache_Meta_Static_Abstract
{
    protected $_model;

    public function __construct($model, $pattern = null)
    {
        parent::__construct($pattern);
        $this->_model = $model;

        $model = $this->_getModel($model);
        $pattern = $this->getPattern();
        $matches = array();
        preg_match_all('/\{([a-z0-9_]+)\}/', $pattern, $matches);
        foreach ($matches[1] as $m) {
            //if (!$model->hasColumn($m)) throw new Kwf_Exception("Model must have column '$m' for pattern '$pattern'");
        }
    }

    public function getModelname($componentClass)
    {
        return $this->_getModelName($this->_model);
    }

    public function getModel()
    {
        return $this->_getModel($this->_model);
    }
}