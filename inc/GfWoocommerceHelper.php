<?php

namespace GfPluginsCore;
//Write all edits of woocommerce here
class GfWoocommerceHelper
{

    public function __construct()
    {
        $this->doActions();
    }

    /**
     * All actions and filters
     */
    private function doActions()
    {
        add_filter('woocommerce_add_to_cart_fragments', [$this, 'updateCart'], 10, 1);
        add_action('woocommerce_register_post', [$this, 'validateExtraRegistrationData'], 10, 3);
        add_action('woocommerce_created_customer', [$this, 'saveExtraRegistrationData']);
        add_filter('woocommerce_login_redirect', [$this, 'redirectAfterLogin']);
        add_filter('woocommerce_registration_redirect', [$this, 'redirectAfterRegister']);
    }

    /**
     * Function is used to update cart totals on frontend, not sure how it works :D
     * @param $fragments
     * @return mixed
     */
    public function updateCart($fragments)
    {

        $fragments['span.header-cart-count'] = '<span class="header-cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';

        return $fragments;

    }

    /**
     * Handling validation of custom fields added to woocommerce
     * @param $username
     * @param $email
     * @param $validation_errors
     * @todo implement validation for length and prevention of special characters
     */
    public function validateExtraRegistrationData($username, $email, $validation_errors)
    {
        if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name'])) {
            $validation_errors->add('billing_first_name_error', __('Ime je obavezno polje!', 'gfShopTheme'));
        }
        if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name'])) {
            $validation_errors->add('billing_last_name_error', __('Prezime je obavezno polje!', 'gfShopTheme'));
        }
        if (isset($_POST['billing_address_1']) && empty($_POST['billing_address_1'])) {
            $validation_errors->add('billing_address_1_error', __('Adresa je obavezno polje!', 'gfShopTheme'));
        }
        if (isset($_POST['billing_city']) && empty($_POST['billing_city'])) {
            $validation_errors->add('billing_city_error', __('Grad je obavezno polje!', 'gfShopTheme'));
        }
        if (isset($_POST['billing_postcode']) && empty($_POST['billing_postcode'])) {
            $validation_errors->add('billing_postcode_error', __('Poštanski broj je obavezno polje!', 'gfShopTheme'));
        }
        if (isset($_POST['billing_phone']) && empty($_POST['billing_phone'])) {
            $validation_errors->add('billing_phone_error', __('Kontakt telefon je obavezno polje!', 'gfShopTheme'));
        }
    }

    /**
     * Updates user meta with custom fields woocommerce uses for customer user type
     * @param $customerId
     */
    public function saveExtraRegistrationData($customerId)
    {
        if (isset($_POST['billing_first_name'])) {
            update_user_meta($customerId, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
        }
        if (isset($_POST['billing_last_name'])) {
            update_user_meta($customerId, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
        }
        if (isset($_POST['billing_address_1'])) {
            update_user_meta($customerId, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']));
        }
        if (isset($_POST['billing_city'])) {
            update_user_meta($customerId, 'billing_city', sanitize_text_field($_POST['billing_city']));
        }
        if (isset($_POST['billing_postcode'])) {
            update_user_meta($customerId, 'billing_postcode', sanitize_text_field($_POST['billing_postcode']));
        }
        if (isset($_POST['billing_phone'])) {
            update_user_meta($customerId, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
        }
        if (isset($_POST['billing_country'])) {
            update_user_meta($customerId, 'billing_country', sanitize_text_field($_POST['billing_country']));
        }
    }

    /**
     * If user registers from checkout page it will be redirected to same page, any other case it will redirect to homepage
     * @param $redirect
     * @return string
     */
    public function redirectAfterLogin($redirect)
    {
        $redirect_page_id = url_to_postid($redirect);
        $checkout_page_id = wc_get_page_id('checkout');

        if ($redirect_page_id == $checkout_page_id) {
            return $redirect;
        }

        return get_page_link(get_page_by_title('Homepage')->ID);
    }

    /**
     * Redirects user to my account dashboard after registration
     * @param $redirect
     * @return string
     */
    public function redirectAfterRegister($redirect)
    {
        return wc_get_page_permalink('myaccount');
    }
}