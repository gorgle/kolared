<?php
/**
 * Created by PhpStorm.
 * User: alexchen
 * Date: 2017/3/15
 * Time: 下午7:31
 */

namespace backend\widgets;


use yii\base\Widget;
use yii\base\InvalidParamException;
use yii\helpers\Html;

class RemoveAllButton extends Widget
{
    public $url;

    public $gridSelector;

    public $htmlOptions = [];

    public $modalSelector = '#delete-confirmation';

    public function init()
    {
        if(!isset($this->url,$this->gridSelector)){
            throw new InvalidParamException('Attribute \'url\' or \'gridSelector\' is not set');
        }
        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = 'deleteItems';
        }
        Html::addCssClass($this->htmlOptions, 'btn');
    }

    public function run()
    {
        $this->registerScript();
        return $this->renderButton();
    }

    protected function renderButton()
    {
        return Html::button(
            '<i class="material-icons">delete</i>  ' .
            \Yii::t('app', 'Delete selected'),
            $this->htmlOptions
        );
    }

    protected function registerScript()
    {
        $this->view->registerJs("
            jQuery('#{$this->htmlOptions['id']}').on('click', function() {
                var items =  $('{$this->gridSelector}').yiiGridView('getSelectedRows');
                if (items.length) {
                    jQuery('{$this->modalSelector}').attr('data-url', '{$this->url}').attr('data-items', items).modal('show');
                }
                return false;
            });
        ");
    }
}