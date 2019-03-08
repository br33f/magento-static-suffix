<?php
/**
 * @author Damian Zamojski
 * @version 1.0.0
 */

class Super_StaticSuffix_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @return bool
     */
    public function isEnabled()
    {
        return Mage::getStoreConfigFlag('dev/static_suffix/enabled');
    }

    /**
     * @return bool
     */
    public function isAutoIncremented()
    {
        return Mage::getStoreConfigFlag('dev/static_suffix/auto');
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return Mage::getStoreConfig('dev/static_suffix/version');
    }

    /**
     * Increments current static suffix version field by 1
     */
    public function incrementVersion()
    {
        $currentVersion = $this->getVersion();
        Mage::getModel('core/config')->saveConfig('dev/static_suffix/version', ++$currentVersion);
        Mage::getModel('core/config')->cleanCache();
    }
}