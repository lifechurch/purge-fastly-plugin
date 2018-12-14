<?php
/**
 * Purge fastly plugin for Craft CMS 3.x
 *
 * Plugin adds specific field for setting fastly surrogate keys. If content has that keys it will be purged by every content save/edit action for every fastly service id(you can add ids on settings page).
 *
 * @link      https://github.com/Belgiets
 * @copyright Copyright (c) 2018 Dmitriy Pashchenko
 */

namespace lifechurch\purgefastly\assetbundles\PurgeFastly;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Dmitriy Pashchenko
 * @package   PurgeFastly
 * @since     1.0.0
 */
class PurgeFastlyAsset extends AssetBundle
{
    /**
     * Initializes the bundle.
     */
    public function init()
    {
        $this->sourcePath = "@lifechurch/purgefastly/assetbundles/purgefastly/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/purge-fastly.min.js',
        ];

        $this->css = [
            'css/purge-fastly.min.css',
        ];

        parent::init();
    }
}
