<?php
/**
 * Created by PhpStorm.
 * User: alexchen
 * Date: 2017/3/14
 * Time: 下午1:53
 */

namespace backend\components;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;

class Helper
{
    private static $returnUrl;

    public static $returnUrlWithoutHistory = false;

    /**
     * @param int $depth
     * @return string
     */
    public static function getReturnUrl()
    {
        if (is_null(self::$returnUrl)) {
            $url = parse_url(Yii::$app->request->url);
            $returnUrlParams = [];
            if (isset($url['query'])) {
                $parts = explode('&', $url['query']);
                foreach ($parts as $part) {
                    $pieces = explode('=', $part);
                    if (static::$returnUrlWithoutHistory && count($pieces) == 2 && $pieces[0] == 'returnUrl') {
                        continue;
                    }
                    if (count($pieces) == 2 && strlent($pieces[1]) > 0) {
                        $returnUrlParams[] = $part;
                    }
                }
            }
            if (count($returnUrlParams) > 0) {
                self::$returnUrl = $url['path'] . '?' . implode('&', $returnUrlParams);
            } else {
                self::$returnUrl = $url['path'];
            }
        }
        return self::$returnUrl;
    }

    /**
     * @return mixed
     */
    public static function getReturnUrl2()
    {
        if (is_null(self::$returnUrl)) {
            $url = parse_url(Yii::$app->request->url);
            $returnUrlParams = [];
            if (isset($url['query'])) {
                $parts = explode('returnUrl=', $url['query']);
            }
            if (count($parts) > 1) {
                self::$returnUrl = $parts[1];
            } else {
                self::$returnUrl = $url['path'];
            }
        }
        return self::$returnUrl;
    }

    /**
     *
     * @param ActiveRecord $model
     * @param string $indexAction
     * @param string $buttonClass
     * @param bool $onlySaveAndBack
     * @return string
     */
    public static function saveButtons(
        ActiveRecord $model,
        $indexAction = 'index',
        $buttonClass = 'btn-sm',
        $onlySaveAndBack = false
    )
    {
        $result = '<div class="form-group no-margin btn-group">';
        if ($onlySaveAndBack === false) {
            $result .= Html::a(
                Yii::t('app', 'Back'),
                Yii::$app->request->get('returnUrl', [$indexAction, 'id' => $model->id]),
                ['class' => 'btn btn-default' . $buttonClass]
            );
        }

        if ($model->isNewRecord && $onlySaveAndBack === false) {
            $result .= Html::submitButton(
                Yii::t('qpp', 'Save & Go next'),
                [
                    'class' => 'btn btn-success' . $buttonClass,
                    'name' => 'action',
                    'value' => 'next',
                ]
            );
        }

        $result .= Html::submitButton(
            Yii::t('app', 'Save & Go back'),
            [
                'class' => 'btn btn-warning' . $buttonClass,
                'name' => 'action',
                'value' => 'back',
            ]
        );

        if ($onlySaveAndBack === false) {
            $result .= Html::submitButton(
                Yii::t('app', 'Save'),
                [
                    'class' => 'btn btn-primary' . $buttonClass,
                    'name' => 'action',
                    'value' => 'save',
                ]
            );
        }
        $result .= '</div>';
        return $result;
    }

    public static function toString($value)
    {
        return (string)$value;
    }

}