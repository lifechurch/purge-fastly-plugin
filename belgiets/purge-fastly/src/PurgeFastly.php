<?php
/**
 * Purge fastly plugin for Craft CMS 3.x
 *
 * Purge fastly services
 *
 * @link      https://github.com/Belgiets
 * @copyright Copyright (c) 2018 Dmitriy Pashchenko
 */

namespace belgiets\purgefastly;

use belgiets\purgefastly\models\Settings;
use belgiets\purgefastly\services\FastlyService;
use belgiets\purgefastly\services\SurrKeysFields;
use Craft;
use craft\events\ElementEvent;
use craft\services\Elements;
use yii\base\Event;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Dmitriy Pashchenko
 * @package   PurgeFastly
 * @since     0.0.1
 *
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class PurgeFastly extends Plugin
{
    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * PurgeFastly::$plugin
     *
     * @var PurgeFastly
     */
    public static $plugin;

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '0.0.1';

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * PurgeFastly::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $this->setComponents([
            'surrKeysFields' => SurrKeysFields::class,
            'fastly' => FastlyService::class
        ]);

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    $this->surrKeysFields->addFields();
                }
            }
        );

        Event::on(
            Elements::class,
            Elements::EVENT_AFTER_SAVE_ELEMENT,
            function (ElementEvent $event) {
                $settings = $this->getSettings();
                $this->fastly->setToken($settings->token);

                foreach ($event->element->getFieldLayout()->getTabs() as $tab) {
                    if ($tab->name === SurrKeysFields::TAB_NAME) {
                        foreach ($tab->getFields() as $field) {
                            if ($field->handle === SurrKeysFields::FIELD_HANDLE) {
                                foreach ($settings->serviceIDs as $id) {
                                    if (!empty($id)) {
                                        $keys = $event->element->getFieldValue(SurrKeysFields::FIELD_HANDLE);

                                        if ($keys) {
                                            $this->fastly->purgeByKey($id, $keys);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        );
    }

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * Returns the rendered settings HTML, which will be inserted into the content
     * block on the settings page.
     *
     * @return string The rendered settings HTML
     * @throws \yii\base\Exception
     */
    protected function settingsHtml()
    {
        return Craft::$app->view->renderTemplate(
            'purge-fastly/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
