<?php


namespace GfPluginsCore;


class GfWpEnqueue {

	public static function actionEnqueueScripts( $function ) {
		add_action( 'wp_enqueue_scripts', static function ($hook) use ( $function ) {
			$function($hook);
		} );
	}

	public static function actionAdminEnqueueScripts( $function ) {
		add_action( 'admin_enqueue_scripts', static function ($hook) use ( $function ) {
			$function($hook);
		} );
	}

	public static function addFrontendStyle( $handle, $src = '', $deps = array(), $ver = false, $media = 'all' ) {
		self::actionEnqueueScripts( static function () use ( $handle, $src, $deps, $ver, $media ) {
			wp_enqueue_style( $handle, $src, $deps, $ver, $media );
		} );
	}

	public static function addFrontendScript( $handle, $src = '', $deps = array(), $ver = false, $in_footer = false ) {
		self::actionEnqueueScripts( static function () use ( $handle, $src, $deps, $ver, $in_footer ) {
			wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
		} );
	}

	public static function addAdminStyle( $handle, $menuSlug, $src = '',  $deps = array(), $ver = false, $media = 'all' ) {
		self::actionAdminEnqueueScripts( static function ($hook) use ( $handle, $menuSlug, $src, $deps, $ver, $media ) {
			if (strpos($hook, $menuSlug) === false) {
				return;
			}
			wp_enqueue_style( $handle, $src, $deps, $ver, $media );
		} );
	}

	public static function addGlobalAdminStyle( $handle, $src = '',  $deps = array(), $ver = false, $media = 'all' ) {
		self::actionAdminEnqueueScripts( static function () use ( $handle, $src, $deps, $ver, $media ) {
			wp_enqueue_style( $handle, $src, $deps, $ver, $media );
		} );
	}

	public static function addAdminScript( $handle, $menuSlug, $src = '', $deps = array(), $ver = false, $in_footer = false) {
		self::actionAdminEnqueueScripts(  static function ($hook) use ( $handle, $menuSlug, $src, $deps, $ver, $in_footer) {
			if (strpos($hook, $menuSlug) === false) {
			return;
		}
			wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
		} );
	}

	public static function removeFrontendStyle( $handle ) {
		self::actionEnqueueScripts( static function () use ( $handle ) {
			wp_dequeue_style( $handle );
			wp_deregister_style( $handle );
		} );
	}

	public static function removeFrontendScript( $handle ) {
		self::actionEnqueueScripts( static function () use ( $handle ) {
			wp_dequeue_script( $handle );
			wp_deregister_script( $handle );
		} );
	}

	public static function list_enqueued_scripts() {
		add_action('wp_print_scripts', static function (){
			global $wp_scripts;
			foreach( $wp_scripts->queue as $handle ) :
				echo $handle . ', ';
			endforeach;
		});
	}
}
