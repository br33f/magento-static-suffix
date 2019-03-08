<?php
/**
 * @author Damian Zamojski
 * @version 1.0.0
 */

class Super_StaticSuffix_Block_Page_Html_Head extends Mage_Page_Block_Html_Head
{
    /**
     * {@inheritdoc}
     *
     * @override
     * Adds version suffix to static resources uri
     */
    protected function &_prepareStaticAndSkinElements($format, array $staticItems, array $skinItems,
                                                      $mergeCallback = null)
    {
        $designPackage = Mage::getDesign();
        $baseJsUrl = Mage::getBaseUrl('js');
        $items = array();
        if ($mergeCallback && !is_callable($mergeCallback)) {
            $mergeCallback = null;
        }

        // get static files from the js folder, no need in lookups
        foreach ($staticItems as $params => $rows) {
            foreach ($rows as $name) {
                $items[$params][] = $mergeCallback ? Mage::getBaseDir() . DS . 'js' . DS . $name : $baseJsUrl . $name;
            }
        }

        // lookup each file basing on current theme configuration
        foreach ($skinItems as $params => $rows) {
            foreach ($rows as $name) {
                $items[$params][] = $mergeCallback ? $designPackage->getFilename($name, array('_type' => 'skin'))
                    : $designPackage->getSkinUrl($name, array());
            }
        }

        $html = '';
        foreach ($items as $params => $rows) {
            // attempt to merge
            $mergedUrl = false;
            if ($mergeCallback) {
                $mergedUrl = call_user_func($mergeCallback, $rows);
            }
            // render elements
            $params = trim($params);
            $params = $params ? ' ' . $params : '';
            if ($mergedUrl) {
                $html .= sprintf($format, $this->getSuffixedUrl($mergedUrl), $params);
            } else {
                foreach ($rows as $src) {
                    $html .= sprintf($format, $this->getSuffixedUrl($src), $params);
                }
            }
        }
        return $html;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function getSuffixedUrl($url) {
        if (Mage::helper('super_staticSuffix')->isEnabled()) {
            $suffix = Mage::helper('super_staticSuffix')->getVersion();
            $url .= "?v=$suffix";
        }

        return $url;
    }
}