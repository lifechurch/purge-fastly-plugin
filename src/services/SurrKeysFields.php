<?php

namespace belgiets\purgefastly\services;


use craft\fields\PlainText;
use craft\models\FieldLayoutTab;
use yii\base\Component;
use Craft;

class SurrKeysFields extends Component
{
    const TAB_NAME = 'Purge Fastly';
    const FIELD_HANDLE = 'surrogateKeys';

    private $fieldsService;

    public function __construct()
    {
        parent::__construct();
        $this->fieldsService = Craft::$app->getFields();
    }

    /**
     * @return \craft\base\FieldInterface|null
     * @throws \Throwable
     */
    private function createFieldLayoutField()
    {
        $field = $this->fieldsService->createField([
            'type' => PlainText::class,
            'id' => null,
            'groupId' => 1,
            'name' => 'Surrogate Keys',
            'handle' => self::FIELD_HANDLE,
            'instructions' => 'Please, add each key separated by space',
            'translationMethod' => PlainText::TRANSLATION_METHOD_NONE,
            'translationKeyFormat' => null,
            'settings' => [
                'placeholder' => '',
                'charLimit' => '',
                'code' => '',
                'multiline' => '',
                'initialRows' => '4',
                'columnType' => 'text',
            ]
        ]);

        return $this->fieldsService->saveField($field) ? $field : null;
    }

    /**
     * @param string $layoutId
     * @return FieldLayoutTab
     */
    private function createFieldLayoutTabModel(string $layoutId)
    {
        $tab = new FieldLayoutTab();
        $tab->sortOrder = 99;
        $tab->name = self::TAB_NAME;
        $tab->layoutId = $layoutId;

        return $tab;
    }

    /**
     * add the tab and field for surrogate keys for every entry type
     *
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function addFields()
    {
        $sectionsService = Craft::$app->getSections();
        $newField = $this->createFieldLayoutField();

        if ($sections = $sectionsService->getAllSections() && !empty($sections)) {
            if (is_array($sections) && $newField) {
                foreach ($sections as $section) {
                    if ($entryTypes = $section->getEntryTypes()) {
                        foreach ($entryTypes as $entryType) {
                            $fieldLayout = $entryType->getFieldLayout();
                            $tabs = $fieldLayout->getTabs();
                            $fields = $fieldLayout->getFields();

                            $tabs[] = $this->createFieldLayoutTabModel($fieldLayout->id);
                            $fieldLayout->setTabs($tabs);

                            $fields[] = $newField;
                            $fieldLayout->setFields($fields);

                            $this->fieldsService->saveLayout($fieldLayout);
                        }
                    }

                }
            }
        }
    }
}