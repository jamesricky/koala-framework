<?php
class Kwf_Assets_Package_ComponentAdmin extends Kwf_Assets_Package_Default
{
    static $_instance;
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        parent::__construct('Admin');
    }

    public function toUrlParameter()
    {
        return 'Admin';
    }

    public static function fromUrlParameter($class, $parameter)
    {
        return self::getInstance();
    }

    public function getPackageUrls($mimeType, $language)
    {
        $ret = parent::getPackageUrls($mimeType, $language);
        $frontendPackage = Kwf_Assets_Package_ComponentFrontend::getInstance();
        $ret = array_merge($ret, $frontendPackage->getPackageUrls($mimeType, $language));

        $packageNames = array();
        foreach (Kwc_Abstract::getComponentClasses() as $cls) {
            if (Kwc_Abstract::getFlag($cls, 'assetsPackage')) {
                $packageName = Kwc_Abstract::getFlag($cls, 'assetsPackage');
                if (!in_array($packageName, $packageNames)) {
                    $packageNames[] = $packageName;
                    $ret = array_merge($ret, Kwf_Assets_Package_ComponentPackage::getInstance($packageName)->getPackageUrls($mimeType, $language));
                }
            }
        }

        return $ret;
    }
}