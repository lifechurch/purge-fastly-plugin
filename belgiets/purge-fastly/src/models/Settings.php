<?php
/**
 * Purge fastly plugin for Craft CMS 3.x
 *
 * Purge fastly services
 *
 * @link      https://github.com/Belgiets
 * @copyright Copyright (c) 2018 Dmitriy Pashchenko
 */

namespace belgiets\purgefastly\models;

use belgiets\purgefastly\PurgeFastly;

use Craft;
use craft\base\Model;

/**
 * PurgeFastly Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Dmitriy Pashchenko
 * @package   PurgeFastly
 * @since     0.0.1
 */
class Settings extends Model
{
    /**
     * @var array
     */
    public $serviceIDs = [''];

    /**
     * @var string
     */
    public $token;

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['serviceIDs', 'each', 'rule' => ['string', 'min' => 22, 'max' => 22]],
            ['token', 'string', 'min' => 32, 'max' => 32]
        ];
    }
}