<?php
/**
 * Purge fastly plugin for Craft CMS 3.x
 *
 * Purge fastly services
 *
 * @link      https://github.com/Belgiets
 * @copyright Copyright (c) 2018 Dmitriy Pashchenko
 */

namespace belgiets\purgefastly\assetbundles\PurgeFastly;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * PurgeFastlyAsset AssetBundle
 *
 * AssetBundle represents a collection of asset files, such as CSS, JS, images.
 *
 * Each asset bundle has a unique name that globally identifies it among all asset bundles used in an application.
 * The name is the [fully qualified class name](http://php.net/manual/en/language.namespaces.rules.php)
 * of the class representing it.
 *
 * An asset bundle can depend on other asset bundles. When registering an asset bundle
 * with a view, all its dependent asset bundles will be automatically registered.
 *
 * http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
 *
 * @author    Dmitriy Pashchenko
 * @package   PurgeFastly
 * @since     0.0.1
 */
class PurgeFastlyAsset extends AssetBundle
{
    /**
     * Initializes the bundle.
     */
    public function init()
    {
        $this->sourcePath = "@belgiets/purgefastly/assetbundles/purgefastly/dist";

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
