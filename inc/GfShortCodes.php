<?php

namespace GfPluginsCore;

class GfShortCodes {

	public static function registerShortCode( $name, $template ) {
		add_shortcode( $name, function ( $atts ) use ( $template ) {
			$data = $atts;
			if ( file_exists( $template ) && ! is_admin() ) {
				include $template;
			}
		} );
	}

	public static function setupShortCode( $templateDir, $templateDirUrl, array $shortCodeConfig ) {
		$template    = $templateDir . '/' . $shortCodeConfig['template'] . '/view/' . $shortCodeConfig['template'] . '.php';
		$templateCss = $templateDirUrl . '/' . $shortCodeConfig['template'] . '/css/' . $shortCodeConfig['template'] . '.css';
		$templateJs  = $templateDirUrl . '/' . $shortCodeConfig['template'] . '/js/' . $shortCodeConfig['template'] . '.js';
		self::registerShortCode( $shortCodeConfig['name'], $template );
		if ( file_exists( $templateCss ) ) {
			GfWpEnqueue::addFrontendStyle( $shortCodeConfig['template'], $templateCss, [ 'bootstrap_css' ] );
		}
		if ( file_exists( $templateJs ) ) {
			GfWpEnqueue::addFrontendScript( $shortCodeConfig['template'], $templateJs, [ 'jqueryUi' ] );
		}

	}

	public static function setupShortCodes( $templateDir, $templateDirUri, array $shortCodesConfig ) {
		foreach ( $shortCodesConfig as $shortCodeConfig ) {
			$template    = $templateDir . '/' . $shortCodeConfig['template'] . '/view/' . $shortCodeConfig['template'] . '.php';
			$templateCss = $templateDirUri . '/' . $shortCodeConfig['template'] . '/css/' . $shortCodeConfig['template'] . '.css';
			$templateJs  = $templateDirUri . '/' . $shortCodeConfig['template'] . '/js/' . $shortCodeConfig['template'] . '.js';
			self::registerShortCode( $shortCodeConfig['name'], $template );
			
			if ( file_exists( $templateDir . '/' . $shortCodeConfig['template'] . '/css/' . $shortCodeConfig['template'] . '.css' ) ) {
				GfWpEnqueue::addFrontendStyle( $shortCodeConfig['template'], $templateCss, [ 'bootstrap_css' ] );
			}
			if ( file_exists( $templateDir . '/' . $shortCodeConfig['template'] . '/js/' . $shortCodeConfig['template'] . '.js' ) ) {
				GfWpEnqueue::addFrontendScript( $shortCodeConfig['template'], $templateJs, [ 'jqueryUi' ] );
			}
		}
	}
}