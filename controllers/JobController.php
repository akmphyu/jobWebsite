<?php

namespace app\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\Job;
use app\models\Category;

class JobController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $job = new Job();

        if ($job->load(Yii::$app->request->post())) {
            if ($job->validate()) {
                // form inputs are valid, do something here
                $job->save();
                yii::$app->getSession()->setFlash('success','Job has been successfully posted');
                return $this->redirect('index.php?r=job');
            }
        }
        return $this->render('create', [
            'job' => $job,
        ]);

    }
    public function actionDetails($id){
        $job = Job::find()
             ->where(['id' => $id])
             ->one();

        return $this->render('details',['job'=>$job]);
    }
    public function actionDelete($id)
    {
        $job = Job::findOne($id);
        $job->delete();
        yii::$app->getSession()->setFlash('success','Job has been successfully deleted');
        return $this->redirect('index.php?r=job');
    }

    public function actionEdit($id)
    {
        $job = Job::find()->where(['id'=>$id])->one();

        if ($job->load(Yii::$app->request->post())) {
            if ($job->validate()) {
                // form inputs are valid, do something here
                $job->save();
                yii::$app->getSession()->setFlash('success','Job has been successfully updated');
                return $this->redirect('index.php?r=job');
            }
        }
        return $this->render('edit', [
            'job' => $job,
        ]);
    }

    public function actionIndex($category = 0)
    {
        $query = Job::find();
        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count(),
        ]);
        if(!empty($category)){
            $jobs = $query->orderBy('create_date DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->where(['category_id'=>$category])
            ->all();
        }else{
            $jobs = $query->orderBy('title')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        }
       
        return $this->render('index',[
            'jobs'=>$jobs,
            'pagination'=>$pagination
        ]);
    }

}
