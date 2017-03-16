<?php
/**
 * Created by PhpStorm.
 * User: alexchen
 * Date: 2017/3/9
 * Time: 下午3:42
 */

namespace backend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class Menu extends Widget
{
    public $linkTemplate = '<a href="{url}" class="{class}">
            <i class="material-icons">{icon}</i>
            <p>{label}</p>
          </a>';

    public $linkNoIconTemplate = '<a href="{url}" class="{class}">
           <p>{label}</p>
         </a>';

    public $labelNoIconTemplate = '<a href="#">{label}</a>';

    public $submenuTemplate = "\n<ul>\n{items}</ul>\n";

    public $items = [];
    public $options = [];

    public $route;

    public $params;

    public function run()
    {
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = $_GET;
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'ul');
        echo Html::tag($tag, $this->renderItems($this->items), $options);
    }

    /**
     * 渲染多项
     * @param $items
     * @return string
     */
    public function renderItems($items)
    {
        $lines = [];
        $tag = ArrayHelper::remove($options, 'tag', 'li');
        foreach ($items as $i => $item) {
            if (isset($item['rback_check']) && $item['rback_check'] && !Yii::$app->user->can($item['rbac_check'])) {
                continue;
            }
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {
                $menu .= strtr(
                    $this->submenuTemplate,
                    [
                        '{items}' => $this->renderItems($item['items']),
                    ]
                );
            }
            $options = [];
            if ($this->isItemActive($item)) {
                $options['class'] = 'active';
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }
        return implode("\n", $lines);
    }

    /**
     * 渲染单项
     * @param $item
     * @return string
     */
    protected function renderItem($item)
    {
        $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
        return strtr(
            $template,
            [
                '{url}' => isset($item['url']) ? Url::to($item['url']) : '#',
                '{label}' => $item['label'],
                '{icon}' => isset($item['icon']) ? $item['icon'] : 'angle-right',
                '{class}' => isset($item['class']) ? $item['class'] : '',
            ]
        );
    }

    /**
     * @param $item
     * @return bool
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->getUniqueId() . '/' . $route;
            }
            if (ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                foreach (array_splice($item['url'], 1) as $name => $value) {
                    if (!isset($this->params[$name]) || $this->params[$name] != $value) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }
}