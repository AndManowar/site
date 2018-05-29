<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 01.03.17
 * Time: 11:48
 */

namespace common\components;

use Yii;
use yii\base\Model;
use yii\bootstrap\ActiveForm;
use yii\web\Response;

/**
 * Trait AjaxValidationTrait
 *
 * @package common\components
 */
trait AjaxValidationTrait
{
    /**
     * @param Model $model
     *
     * @return array|null
     */
    protected function modelAjaxValidation(Model $model)
    {
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        return null;
    }

    /**
     * @param Model[] $models
     * @return array|null
     */
    protected function validateMultipleModels(array $models)
    {
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validateMultiple($models);
        }

        return null;
    }

    /**
     * @param Model $model
     * @param Model[] $models
     * @return array|null
     */
    protected function validateModelAndModels(Model $model, array $models)
    {
        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $modelErrors = ActiveForm::validate($model);
            $modelsFieldsErrors = ActiveForm::validateMultiple($models);

            return array_merge($modelErrors, $modelsFieldsErrors);
        }

        return null;
    }
}