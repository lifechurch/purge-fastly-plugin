<?php
/**
 * Purge fastly plugin for Craft CMS 3.x
 *
 * Purge fastly services
 *
 * @link      https://github.com/Belgiets
 * @copyright Copyright (c) 2018 Dmitriy Pashchenko
 */

namespace lifechurch\purgefastly\models;

use lifechurch\purgefastly\PurgeFastly;

use Craft;
use craft\base\Model;

/**
 * @author    Dmitriy Pashchenko
 * @package   PurgeFastly
 * @since     1.0.0
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
            ['serviceIDs', 'each', 'rule' => ['string', 'min' => 22]],
            ['token', 'string', 'min' => 32, 'max' => 32]
        ];
    }
}
