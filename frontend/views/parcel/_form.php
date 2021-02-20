<?php

use common\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Parcel */
/* @var $form yii\widgets\ActiveForm */
/* @var $url Url */
?>

<div class="parcel-form">
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>

    <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(Category::getCategories(),[
        'prompt' => '---Select category---',
    ]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'sent' => 'Sent', 'received' => 'Received', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$url = $model->isNewRecord ? Yii::$app->controller->action->id :  Yii::$app->controller->action->id . "?id=$model->id";
$js = <<<JS
$('form').on('submit',function(event) {
  event.preventDefault();
   $.ajax({
        type: 'POST',
        url: '$url',
        data: $(this).serialize(),
        success: function () {
            $('.modal').modal('hide');
            $.pjax.reload({container:"#pjax-grid-parcel"});
        }
    });
});
JS;
$this->registerJs($js);
