<?php

namespace app\controllers;

use app\models\Dish;
use app\models\Ingredient;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DishController implements the CRUD actions for Dish model.
 */
class DishController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Dish models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Dish::find()
                ->joinWith('dishToIngredients')
                ->leftJoin('ingredient', 'ingredient.id = dish_to_ingredient.ingredient_id')
                ->groupBy('id')
                ->having(['AVG(`ingredient`.`visible`)' => 1]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dish model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dish model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $error = null;
        $model = new Dish();

        if ($model->load(Yii::$app->request->post())) {
            $ingredients = Yii::$app->request->post('ingredients');
            $this->relationForIngredients($ingredients, $model, $error);
        }

        return $this->render('create', [
            'model' => $model,
            'data' => Ingredient::getDataForMultiselect(),
            'error' => $error
        ]);
    }

    /**
     * Updates an existing Dish model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $error = NULL;

        if ($model->load(Yii::$app->request->post())) {
            $ingredients = Yii::$app->request->post('ingredients');
            $this->relationForIngredients($ingredients, $model, $error);
        }

        $ingredients = [];
        foreach ($model->dishToIngredients as $ingredient) {
            $ingredients[] = $ingredient->ingredient->id;
        }

        return $this->render('update', [
            'model' => $model,
            'data' => Ingredient::getDataForMultiselect(),
            'ingredients' => $ingredients,
            'error' => $error
        ]);
    }

    /**
     * Deletes an existing Dish model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dish model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dish the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dish::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Creating an association between dishes and ingredients and preserving dishes
     * @param $ingredients
     * @param $model
     * @param $error
     * @return string|\yii\web\Response
     */
    protected function relationForIngredients($ingredients, $model, &$error) {

        if (!empty($ingredients)) {
            $model->save();
            $model->associate(Yii::$app->request->post('ingredients'));
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $error = "Выбирите хотя бы один ингредиент для блюда";
        }
    }
}
