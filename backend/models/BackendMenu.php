<?php

namespace backend\models;

use backend\behaviors\ActiveRecordHelper;
use backend\behaviors\Tree;
use Yii;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "backend_menu".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $route
 * @property string $icon
 * @property integer $sort_order
 * @property string $added_by_ext
 * @property string $rbac_check
 * @property string $css_class
 * @property string $translation_category
 */
class BackendMenu extends \yii\db\ActiveRecord
{
    private static $identity_map = [];

    public function behaviors()
    {
        return [
            [
                'class' => ActiveRecordHelper::className(),
            ],
            [
                'class' => Tree::className(),
                'activeAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'backend_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort_order'], 'integer'],
            [['name', 'route'], 'required'],
            [['name', 'route', 'icon', 'added_by_ext', 'css_class'], 'string', 'max' => 255],
            [['rbac_check'], 'string', 'max' => 64],
            [['translation_category'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'route' => 'Route',
            'icon' => 'Icon',
            'sort_order' => 'Sort Order',
            'added_by_ext' => 'Added By Ext',
            'rbac_check' => 'Rbac Check',
            'css_class' => 'Css Class',
            'translation_category' => 'Translation Category',
        ];
    }

    public function scenarios()
    {
        return [
            'default' => [
                'parent_id','name','route','icon','rbac_check','added_by_ext',
                'css_class','sort_order','translation_category',
            ],
            'search' => [
                'id','parent_id','name','route','icon','aadded_by_ext'
            ],
        ];
    }

    /**
     * Search support for GridView and etc.
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /* @var $query \yii\db\ActiveQuery */
        $query = self::find()
            ->where(['parent_id' => $this->parent_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if(!($this->load($params))){
            return $dataProvider;
        }
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like','name',$this->name]);
        $query->andFilterWhere(['like','route',$this->route]);
        $query->andFilterWhere(['like','icon',$this->icon]);
        $query->andFilterWhere(['like','added_by_ext',$this->added_by_ext]);
        return $dataProvider;
    }

    /**
     *
     * @param $id
     * @return mixed
     */
    public static function findById($id)
    {
        if(!isset(static::$identity_map[$id])){
            $cacheKey = static::tableName().":$id";
            if(false === $model = Yii::$app->cache->get($cacheKey)){
                $model = static::find()->where(['id' => $id]);

                if(null !== $model = $model->one()){
                    Yii::$app->cache->set(
                        $cacheKey,
                        $model,
                        86400,
                        new TagDependency([
                            'tags' => [
                                ActiveRecordHelper::getCommonTag(static::className())
                            ]
                        ])
                    );
                }
                static::$identity_map[$id] = $model;
            }
        }
        return static::$identity_map[$id];
    }

    public static function getAllMenu()
    {
        $rows = Yii::$app->cache->get("BackendMenu:all");
        $rows = null;
        if(false === is_array($rows)){

            $rows = static::find()
                ->orderBy('parent_id ASC,sort_order ASC')
                ->asArray()
                ->all();


            Yii::$app->cache->set(
                "BackendMenu:all",
                $rows,
                86400,
                new TagDependency([
                    'tags' => [ActiveRecordHelper::getCommonTag(static::className())]
                ])
            );
        }

        // rebuild rows to tree $all_menu_items
        $all_menu_items = Tree::rowsArrayToMenuTree($rows,1,1,false);
        return $all_menu_items;
    }
}
