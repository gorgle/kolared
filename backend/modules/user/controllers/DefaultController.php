<?php

namespace backend\modules\user\controllers;

use Yii;
use backend\components\SearchModel;
use common\models\User;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\rbac\Item;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchModel([
            'model' => '\common\models\User',
            'partialMatchAttributes' => [
                'username',
                'email',
                'created_at',
            ]
        ]);

        $dataProvider = $searchModel->search($_GET);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderContent('Hello World');
    }


    public function actionUpdate($id = null)
    {
        if(is_null($id)){
            $model = new User(['scenario' => 'adminReg']);
            $model->generateAuthKey();
        }else{
            $model = $this->findModel($id);
            $model->scenario = 'admin';
            // @todo update user group
//            $model->updateProperGroupsInformation(true);
        }
        $assignments = Yii::$app->authManager->getAssignments($id);
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());
            $model->auth_key = '';
            if($model->validate()){
                if($id !== null && !empty($model->password)){
                    $model->setPassword($model->password);
                }
                $model->save();
                $postAssignments = Yii::$app->request->post('AuthAssignment',[]);
                $errors = [];
                foreach ($assignments as $assignment){
                    $key = array_search($assignment->roleName,$postAssignments);
                    if($key === false){
                        Yii::$app->authManager->revoke(new Item(['name' => $assignment->roleName]),$model->id);
                    }else{
                        unset($postAssignments);
                    }
                }
                foreach ($postAssignments as $assignment){
                    try{
                        Yii::$app->authManager->assign(new Item(['name' => $assignment]),$model->id);
                    }catch (\Exception $e){
                        $errors[] = 'Cannot assign "'.$assignment.'" to user';
                    }
                }
                if(count($errors)>0){
                    Yii::$app->getSession()->setFlash('error',implode('<br/>',$errors));
                }
                Yii::$app->session->setFlash('success',Yii::t('app','Record has been saved'));
                $returnUrl = Yii::$app->request->get('returnUrl',['index']);
                switch (Yii::$app->request->post('action','save')){
                    case 'next':
                        return $this->redirect([
                            'update',
                            'returnUrl' => $returnUrl,
                        ]);
                    case 'back':
                        return $this->redirect($returnUrl);
                    default:
                        return $this->redirect(Url::toRoute([
                            'update',
                            'id' => $id,
                            'returnUrl' => $returnUrl,
                        ]));
                }
            }
        }

        return $this->render('update',[
            'model' => $model,
            'assignments' => ArrayHelper::map($assignments,'roleName','roleName'),
        ]);
    }

    protected function findModel($id)
    {
        if(($model = User::findOne($id)) !== null){
            return $model;
        }else{
            throw new NotFoundHttpException('The requested resource does not exist.');
        }
    }
}
