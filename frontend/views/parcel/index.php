<?php

use backend\models\Category;
use common\models\Parcel;
use common\models\User;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
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
        'timeout' => false,
        'enablePushState' => false,
    ]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'created_at',
                'value' => function($data){
                    return $data->created_at;
                },
                'filter' => DatePicker::widget([
                    'name' => 'created_at',
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]),
            ],
            'weight',
            'size',
            [
                'attribute' => 'category_id',
                'value' => function($data){
                    $category = $data->category;

                    return $category ? $category->name : 'Not set';
                },
                'filter' => Category::getCategories(),
            ],
            'price',
            [
                'attribute' => 'user_id',
                'value' => function($data){
                    $recipient = $data->user;

                    return $recipient ? $recipient->first_name . ' ' . $recipient->last_name : 'Not set';
                },
                'filter' => User::getUsersList(),
            ],
            [
                'attribute' => 'status',
                'value' => function($data){
                    return $data->status;
                },
                'filter' => Parcel::LIST_STATUSES,
            ],
            [
                'attribute' => 'recipient_id',
                'value' => function($data){
                    $recipient = $data->userRecipient;

                    return $recipient ? $recipient->first_name . ' ' . $recipient->last_name : 'Not set';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'options'=>['class'=>'action-column'],
                'template'=>'{view}{update}{print-declaration}{delete}',
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
                    'print-declaration' => function ($url, $model, $key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-print"></span>',
                            $url,
                            [
                                'title' => 'Print Declaration',
                            ]
                        );
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
