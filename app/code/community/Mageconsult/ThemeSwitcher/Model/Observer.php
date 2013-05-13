<?php

/**
 * Class Mageconsult_Themeswitcher_Model_Observer
 */
class Mageconsult_Themeswitcher_Model_Observer
{

    /**
     * check if there should be set a theme other than default
     * @param $observer
     */
    public static function controller_action_predispatch()
    {
        // check, if this is an AJAX-Request
        if (Mage::app()->getRequest()->isXmlHttpRequest()) {
            return;
        }

        // set theme to default
        $defaultTheme = 'default';

        // is there configured theme than default?
        $configuredTheme = Mage::getStoreConfig('design/theme/default');
        if ($configuredTheme != '') {
            $defaultTheme = $configuredTheme;
        }

        // allowed themes
        $allowAllThemes = true;
        $allowedThemes = Mage::getStoreConfig('dev/mageconsult_themeswitcher/allowedThemes');
        if (trim($allowedThemes) != '') {
            $allowedThemes = explode(',', $allowedThemes);
            if (is_array($allowedThemes) && count($allowedThemes) > 0) {
                $allowAllThemes = false;
            }
        }

        // get cookie-lifetime from storeconfig
        $cookieLifetime = Mage::getStoreConfig('dev/mageconsult_themeswitcher/cookieLifetime');
        if ($cookieLifetime == '' OR !is_numeric($cookieLifetime)) {
            $cookieLifetime = true;
        }

        // check, if user wants to change storeview
        $themeChange = Mage::app()->getRequest()->getParam('___theme');

        // is this storeview allowed?
        if (!is_null($themeChange) && ($allowAllThemes || in_array($themeChange, $allowedThemes))) {
            // set cookie and themename
            $cookie = Mage::getModel('core/cookie')->set('theme', $themeChange, $cookieLifetime);
            $defaultTheme = $themeChange;
        } // no change by parameter, is there already a cookie set?
        elseif (Mage::getModel('core/cookie')->get('theme') !== false) {
            $defaultTheme = Mage::getModel('core/cookie')->get('theme');
        }

        // is the storename from cookie or request allowed (again)?
        if ($allowAllThemes || in_array($defaultTheme, $allowedThemes)) {
            // get design
            $design = Mage::getDesign();
            // set theme
            $design->setTheme($defaultTheme);
            $design->setTheme('default', $defaultTheme);
        }
    }
}