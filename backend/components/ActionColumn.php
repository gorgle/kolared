<?php
/**
 * Created by PhpStorm.
 * User: alexchen
 * Date: 2017/3/14
 * Time: 下午12:57
 */

namespace backend\components;

use Yii;
use yii\grid\Column;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class ActionColumn extends Column
{
    public $buttons;

    private $defaultButtons = [];

    private $callbackButtons;

    public $controller;

    public $urlCreator;

    public $url_append = '';

    public $appendReturnUrl = true;


    public function init()
    {
        parent::init();

        $this->defaultButtons = [
            [
                'url' => 'edit',
                'icon' => 'pencil',
                'class' => 'btn-primary',
                'label' => Yii::t('app', 'Edit'),
            ],
            [
                'url' => 'delete',
                'icon' => 'trash-o',
                'class' => 'btn-primary',
                'label' => Yii::t('app', 'Delete'),
            ],
            [
                'url' => 'update',
                'icon' => 'pencil',
                'class' => 'btn-primary',
                'label' => Yii::t('app', 'Update'),
            ],
        ];

        if (null === $this->buttons) {
            $this->buttons = $this->defaultButtons;
        } elseif ($this->buttons instanceof \Closure) {
            $this->callbackButtons = $this->buttons;
        }
    }

    /**
     * @param $action
     * @param $model
     * @param $key
     * @param $index
     * @param null $appendReturnUrl
     * @param null $url_append
     * @param string $keyParam
     * @param array $attrs
     * @return mixed|string
     */
    public function createUrl(
        $action,
        $model,
        $key,
        $index,
        $appendReturnUrl = null,
        $url_append = null,
        $keyParam = 'id',
        $attrs = []
    )
    {
        if ($this->urlCreator instanceof \Closure) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index);
        } else {
            $params = [];
            if (is_array($key)) {
                $params = $key;
            } else {
                if (is_null($keyParam) === false) {
                    $params = [$keyParam => (string)$key];
                }
            }
            $params[0] = $this->controller ? $this->controller . '/' . $action : $action;
            foreach ($attrs as $attrName) {
                if ($attrName === 'model') {
                    $params['model'] = $model;
                } else {
                    $params[$attrName] = $model->getAttribute($attrName);
                }
            }
            if (is_null($appendReturnUrl) === false) {
                $appendReturnUrl = $this->appendReturnUrl;
            }
            if (is_null($url_append) === true) {
                $url_append = $this->url_append;
            }
            if ($appendReturnUrl) {
                $params['returnUrl'] = \backend\components\Helper::getReturnUrl();
            }
            return Url::toRoute($params) . $url_append;
        }
    }

    /**
     * @param mixed $model
     * @param mixed $key
     * @param int $index
     * @return string
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->callbackButtons instanceof \Closure) {
            $btns = call_user_func($this->callbackButtons, $model, $key, $index, $this);
            if (null === $btns) {
                $this->buttons = $this->defaultButtons;
            } else {
                $this->buttons = $btns;
            }
        }
        $minWidth = count($this->buttons) * 50;
        $data = Html::beginTag('div', ['style' => 'min-width:' . $minWidth . 'px']);
        foreach ($this->buttons as $button) {
            $appendReturnUrl = ArrayHelper::getValue($button, 'appendReturnUrl', $this->appendReturnUrl);
            $url_append = ArrayHelper::getValue($button, 'url_append', $this->url_append);
            $keyParam = ArrayHelper::getValue($button, 'keyParam', 'id');
            $attrs = ArrayHelper::getValue($button, 'attrs', []);
            Html::addCssClass($button, 'btn btn-simple btn-xs');
            $buttonText = isset($button['text']) ? '' . $button['text'] : '';
            $data .= Html::a(
                    '<i class="material-icons">'.$button['icon'].'</i>',
                    $url = $this->createUrl($button['url'], $model, $key, $index, $appendReturnUrl, $url_append, $keyParam, $attrs),
                    ArrayHelper::merge(
                        isset($button['options']) ? $button['options'] : [],
                        [
                            'class' => $button['class'],
                            'title' => $button['label'],
                        ]
                    )
                ) . '';
        }
        $data .= '</div>';
        return $data;
    }
}