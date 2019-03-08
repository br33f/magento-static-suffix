<?php
/**
 * @author Damian Zamojski
 * @version 1.0.0
 */

class Super_StaticSuffix_Model_Observer
{
    public function cleanMediaCacheAfter()
    {
        if (Mage::helper('super_staticSuffix')->isEnabled() && Mage::helper('super_staticSuffix')->isAutoIncremented()) {
            Mage::helper('super_staticSuffix')->incrementVersion();
        }
    }
}