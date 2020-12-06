<?php
/*
Plugin Name: GF Plugins
Plugin URI:
Description: Green friends shop theme plugins
Author: Green Friends
Author URI: http://greenfriends.systems/?fbclid=IwAR3QsWAtYm_dT1UD4vPu245_L1ZVIbrUNomZZQmEwu0UpeZelEK30s3r158
Version: 1.0.0
*/

namespace GfPluginsCore;
define('PLUGIN_DIR_URI',plugin_dir_url( __DIR__ . '/gfShopThemePlugins/'));
define('PLUGIN_DIR', __DIR__ . '/');
//loader for helper classes for theme and plugins

//foreach (new \DirectoryIterator(PLUGIN_DIR . '/inc/') as $file){
//	if ($file->isFile()){
//		require $file->getPath() . '/' .$file->getBasename();
//	}
//}
//foreach (new \DirectoryIterator(PLUGIN_DIR . '/plugins/') as $file){
//    if ($file->isFile()){
//        require $file->getPath() . '/' .$file->getBasename();
//    }
//}

require_once(__DIR__ . "/inc/GfShortCodes.php");
require_once(__DIR__ . "/inc/GfWoocommerceHelper.php");
require_once(__DIR__ . "/inc/GfWpEnqueue.php");
require_once(__DIR__ . "/plugins/ProductStickers.php");
require_once(__DIR__ . "/plugins/CategoryProductSlider.php");


/**
 *
 * Trenutno će se settings pagevi konfigurisati kroz array, u budučnosti možemo i napraviti core clasu
 * al za sada mislim da je ovo bolje zbog perfomansi pošto je kod za kreiranje settinga za plugin isti pa ne
 * vidim poentu pravljenja posebnih klasa
 *
 */
class GfShopThemePlugins {

    public function __construct() {
        $this->init();
    }

    private function actionAdminMenu( $function ) {
        add_action( 'admin_menu', function () use ( $function ) {
            $function();
        } );
    }

    private function init() {
        GfWpEnqueue::actionAdminEnqueueScripts( static function (){
            wp_enqueue_media();
        });
        $this->setupPlugins();

        add_action('widgets_init', function (){
            register_widget(__NAMESPACE__.'\CategoryProductSlider');
        });
    }

    private function setupPlugins() {
        foreach ( glob( __DIR__ . '/config/plugins/*.php' ) as $file ) {
            $pluginInfo   = require $file;
            $adminTemplateDirUri = PLUGIN_DIR_URI . 'templates/admin/';
            $scTemplateDir = PLUGIN_DIR . 'templates/shortcodes';
            $pageTitle    = $pluginInfo['settingPage']['pageTitle'];
            $menuTitle    = $pluginInfo['settingPage']['menuTitle'];
            $capability   = $pluginInfo['settingPage']['capability'];
            $menuSlug     = $pluginInfo['settingPage']['menuSlug'];
            $templateName = $pluginInfo['settingPage']['template'];
            $optionGroup  = $pluginInfo['registerSettings']['optionGroup'];

            foreach ( $pluginInfo['registerSettings']['options'] as $optionName => $optionArgs ) {
                $this->registerSetting( $optionGroup, $optionName, $optionArgs );
            }

            $this->addSubmenuPage( $pageTitle, $menuTitle, $capability, $menuSlug, $templateName );
            GfWpEnqueue::addAdminStyle($templateName, $menuSlug, $adminTemplateDirUri . $templateName . '/css/'. $templateName .'.css',['bootstrap_css']);
            GfWpEnqueue::addAdminStyle('bootstrap_css', $menuSlug, 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' );
            GfWpEnqueue::addAdminScript($templateName, $menuSlug,$adminTemplateDirUri . $templateName . '/js/'. $templateName .'.js');
            GfShortCodes::setupShortCode($scTemplateDir, $scTemplateDir,$pluginInfo['shortCode']);
        }
    }

    private function addSubmenuPage( $pageTitle, $menuTitle, $capability, $menuSlug, $templateName ) {
        $this->actionAdminMenu( function () use ( $pageTitle, $menuTitle, $capability, $menuSlug, $templateName ) {
            add_submenu_page( 'nss-panel', $pageTitle, $menuTitle, $capability, $menuSlug, function () use ( $templateName ) {
                $this->getTemplatePart( 'admin', $templateName );
            } );
        } );

        return $this;
    }

    /*
     * Page is empty because its not used its only used to create header menu for settings
     */
    private function addMainSettingPage() {
        $this->actionAdminMenu( function () {
            add_menu_page( 'Theme plugin settings', 'Theme plugin settings', 'manage_options', 'theme_plugins', function () {
                echo '';
            } );
        } );
    }

    public function getTemplatePart( $section, $name ) {
        require_once PLUGIN_DIR . '/templates/' . $section . '/' . $name . '/view/' . $name .'.php';
    }

    public static function getTemplatePartials($section, $pluginName, $fileName, $data = []){
        require PLUGIN_DIR . '/templates/' . $section . '/' . $pluginName . '/view/' . $fileName .'.php';
    }

    private function registerSetting( $optionGroup, $optionName, $optionArgs ) {
        $this->actionAdminMenu( function () use ( $optionGroup, $optionName, $optionArgs ) {
            if ( count( $optionArgs ) > 0 ) {
                register_setting( $optionGroup, $optionName, $optionArgs );
            }
            register_setting( $optionGroup, $optionName );
        } );
    }
}

new GfShopThemePlugins();