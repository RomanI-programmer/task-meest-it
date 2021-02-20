<?php

use common\models\Parcel;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ParcelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model Parcel */

$this->title = 'Parcels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parcel-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= '' // Html::a('Create Parcel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    // Create modal
    Modal::begin([
         'id' => 'modal-create-parcel',
         'size' => Modal::SIZE_LARGE,
         'toggleButton' => [
             'label' => 'Create Parcel',
             'class' => 'btn btn-success new-parcel',
             'onclick' => 'createParcel()',
         ],
     ]);

    echo "<div id='createParcelModal'></div>";

    Modal::end();

    // Update modal
    Modal::begin([
         'id' => 'modal-update-parcel',
         'size' => Modal::SIZE_LARGE,
     ]);

    echo "<div id='updateParcelContent'></div>";

    Modal::end();

    // View modal

    Modal::begin([
         'id' => 'modal-view-parcel',
         'size' => Modal::SIZE_LARGE,
     ]);

    echo "<div id='viewParcelContent'></div>";

    Modal::end();

    ?>

    <?php Pjax::begin([
        'id' => 'pjax-grid-parcel',
    ]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'created_at',
//            'updated_at',
            'weight',
            'size',
            'category_id',
            'price',
            'status',
            //'user_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'options'=>['class'=>'action-column'],
                'template'=>'{view}{update}{delete}',
                'buttons'=>[
                    'view' => function($url,$model,$key){
                        return Html::button("<span class='glyphicon glyphicon-eye-open'></span>", [
                            'title' => 'Update',
                            'onclick' => "viewParcel('{$key}')"
                        ]);
                    },
                    'update' => function($url,$model,$key){
                        return Html::button("<span class='glyphicon glyphicon-pencil'></span>", [
                            'title' => 'Update',
                            'onclick' => "updateParcel('{$key}')"
                        ]);
                    },
                    'delete' => function($url,$model,$key){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => 'Delete',
                            'data-confirm' => 'Are you sure you want to delete this item?',
                            'data-method' => 'post',
                            'data-pjax' => 1,
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
