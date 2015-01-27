<?php

namespace Zelenin\yii\SemanticUI\modules;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use Zelenin\yii\SemanticUI\InputWidget;

class Checkbox extends InputWidget
{
    public $label;
    public $labelOptions = [];

    public $checkboxOptions = [];
    public $checked = false;

    public $type = self::TYPE_CHECKBOX;
    const TYPE_CHECKBOX = '';
    const TYPE_SLIDER = 'slider';
    const TYPE_TOGGLE = 'toggle';

    public $readOnly = false;
    const TYPE_READONLY = 'read-only';

    public $disabled = false;
    const TYPE_DISABLED = 'disabled';

    public $fitted = false;
    const TYPE_FITTED = 'fitted';

    public function run()
    {
        $this->registerJs();
        Html::addCssClass($this->options, 'ui ' . $this->type . ' checkbox');
        if($this->readOnly) {
            Html::addCssClass($this->options, self::TYPE_READONLY);
        }
        if($this->disabled) {
            Html::addCssClass($this->options, self::TYPE_DISABLED);
        }
        if($this->fitted) {
            Html::addCssClass($this->options, self::TYPE_FITTED);
        }

        //$this->options['label'] = null;

        echo Html::tag('div', $this->renderInput() . $this->renderLabel(), $this->options);
    }

    public function renderInput()
    {
        if (!isset($this->checkboxOptions['id'])) {
            $id = $this->getId() . '-' . ($this->hasModel() ? $this->attribute : $this->name);
            $this->checkboxOptions['id'] = $id;
        }
        return $this->hasModel()
            ? Html::activeCheckbox($this->model, $this->attribute, $this->checkboxOptions)
            : Html::checkbox($this->name, $this->checked, $this->checkboxOptions);
    }

    public function renderLabel()
    {
        if (!isset($this->labelOptions['for'])) {
            $this->labelOptions['for'] = $this->checkboxOptions['id'];
        }
        return $this->hasModel()
            ? Html::activeLabel($this->model, $this->attribute, $this->labelOptions)
            : Html::label($this->label, $this->labelOptions['for'], $this->labelOptions);
    }

    public function registerJs()
    {
        $this->registerJsAsset();
        $clientOptions = $this->clientOptions ? Json::encode($this->clientOptions) : null;
        $this->getView()->registerJs('jQuery("#' . $this->getId() . '").checkbox(' . $clientOptions . ');');
    }
}
