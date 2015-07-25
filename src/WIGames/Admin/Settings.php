<?php

/*
 * This file is part of the WIGames Plugin package.
 *
 * (c) Artprima <ask@artprima.cz>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


/**
 * Class Settings
 *
 * @author Artprima <ask@artprima.cz>
 *
 */
class WIGames_Admin_Settings
{
    private $pluginRoot;

    public function __construct()
    {
        $this->pluginRoot = dirname(dirname(dirname(dirname(__FILE__))));

        add_action('plugins_loaded', array($this, 'loadTextDomain'));
        add_action('admin_init', array($this, 'init'));
        add_action('admin_menu', array($this, 'addPage'));
        add_action('admin_enqueue_scripts', array($this, 'loadStyles'));
    }

    public function init()
    {
        register_setting('wi_games_settings', 'wi_games_plugin_settings', array($this, 'save'));
    }

    public function loadStyles() {
        wp_register_style('wi_games_wp_admin_css', plugins_url('assets/css/admin-style.css', $this->pluginRoot.'/plugin.php'), false, '1.0.0');
        wp_enqueue_style('wi_games_wp_admin_css');
    }

    public function loadTextDomain()
    {
        load_plugin_textdomain('wigames', false, dirname(plugin_basename($this->pluginRoot.'/plugin.php')).'/locale');
    }

    public function save($setting)
    {
        if (!isset($setting['widget_code'])) {
            $setting['widget_code'] = '';
        }

        return array(
            'widget_code' => (string) $setting['widget_code'],
        );
    }

    public function addPage()
    {
        /*
        add_options_page(
            __('WI Games Settings', 'wigames'),
            __('WI Games Settings', 'wigames'),
            'activate_plugins',
            'wi-games-settings',
            array($this, 'handlePage')
        );
        */

        add_menu_page(
            __('WI Games Settings', 'wigames'),
            __('WI Games', 'wigames'),
            'activate_plugins',
            'wi-games-settings',
            array($this, 'handlePage'),
            plugins_url('assets/img/wigamesicon32.png', $this->pluginRoot.'/plugin.php'),
            66
        );
    }

    public function handlePage()
    {
        $page = '
            <div class="wrap">
            <h2> ' . __('WI Games WIDGET Settings', 'wigames') . '</h2>
            <p><img src="'.plugins_url('assets/img/head.jpg', $this->pluginRoot.'/plugin.php').'" style="max-width: 100%"/></p>
            <p>'.__('This plugin will help you to smoothly integrate WI Games widget to your website.', 'wigames').'</p>
            <h3><a href="'.esc_attr(WI_GAMES_REG_LINK).'" target="_blank">'.__('Registration', 'wigames').'</a><h3>
            <h3>
                <a href="'.esc_attr(WI_GAMES_SETUP_HELP_LINK).'" target="_blank">'.__('Setup Instructions', 'wigames').'</a>
                    |
                <a href="'.esc_attr(WI_GAMES_FAQ_LINK).'" target="_blank">'.__('F.A.Q.', 'wigames').'</a>
            <h3>
        ';

        ob_start();
        settings_fields('wi_games_settings');
        $fields = ob_get_clean();
        $fields .= wp_nonce_field('save-wigames-settings', '_wpnonce_wi', false, false);

        $options = get_option('wi_games_plugin_settings');

        if (!is_array($options)) {
            $options = array(
                'widget_code' => '',
            );
        }

        if (!isset($options['widget_code'])) {
            $options['widget_code'] = '';
        }

        $page .= '
            </div>
            <form method="post" action="options.php">
                ' . $fields . '
                <h3 class="title">'.__('Main', 'wigames').'</h3>
                <table class="form-table" style="max-width: 600px" border="0">
                    <tr>
                        <th scope="row">'.__('Widget Code', 'wigames').'</td>
                        <td>
                            <textarea name="wi_games_plugin_settings[widget_code]" id="wi_games_plugin_settings[widget_code]" class="large-text code">'.
                                esc_html($options['widget_code']).
                            '</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" class="button button-primary" value="'.esc_attr(__('Submit', 'wigames')).'" /></td>
                    </tr>
                </table>
            </form>
        ';

        echo $page;
    }

}
