<?php
use yii\grid\GridView;

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="card">
        <div class="card-content">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'layout' => "{items}\n{summary}\n{pager}",
                'tableOptions' => ['class' => 'table'],
                'columns' => [
                    ['class' => \yii\grid\CheckboxColumn::className(),],
                    'id',
                    'username',
                    'created_at:datetime',
                    [
                        'class' => \backend\components\ActionColumn::class,
                        'options' => [
                            'width' => '95px',
                        ],
                        'buttons' => [
                            [
                                'url' => 'update',
                                'icon' => 'edit',
                                'class' => 'btn-primary',
                                'label' => Yii::t('app', 'Edit'),
                            ],
                            [
                                'url' => 'allow',
                                'icon' => 'check_circle',
                                'class' => 'btn-success',
                                'label' => Yii::t('app', 'Allow'),
                            ],
                            [
                                'url' => 'stop',
                                'icon' => 'not_interested',
                                'class' => 'btn-default',
                                'label' => Yii::t('app', 'Stop'),
                            ]
                        ],
                    ]
                ],
            ])
            ?>


            <div class="row">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group pull-right">
                        <?= \backend\widgets\RemoveAllButton::widget([
                            'url' => 'default/remove-all',
//                            'options' => ['id' => 'users-grid'],
                            'gridSelector' => '.grid-view',
                            'htmlOptions' => [
                                'class' => 'btn btn-danger pull-left'
                            ]
                        ]) ?>
                        <?= \yii\helpers\Html::a('<i class="material-icons">control_point</i>Add', ['default/update'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
