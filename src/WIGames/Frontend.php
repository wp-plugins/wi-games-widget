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
 * Class Frontend
 *
 * @author Artprima <ask@artprima.cz>
 *
 */
class WIGames_Frontend
{
    private $options;

    public function __construct()
    {
        add_action('wp_head', array($this, 'doHeader'));
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
    }

    private function getOptions()
    {
        if (empty($this->options)) {
            $options = get_option('wi_games_plugin_settings');
            if (!is_array($options)) {
                $options = array(
                    'widget_code' => '',
                );
            }
    
            $this->options = $options;
        }

        return $this->options;
    }

    public function doHeader()
    {
        $options = $this->getOptions();
        if ($options['widget_code']) {
            echo $options['widget_code'];
        }
    }

    public function enqueueScripts()
    {
        $options = $this->getOptions();
        if ($options['widget_code']) {
            wp_enqueue_script('jquery');
        }
    }
}