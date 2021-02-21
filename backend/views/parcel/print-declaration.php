<?php

use backend\models\Parcel;
use yii\bootstrap\Html;

/** @var $qr \xj\qrcode\QRcode */
/** @var $parcel Parcel */

?>

<div>
    <?= Html::label('Weight:') ?>
    <?= $parcel->weight ?>
</div>

<div>
    <?= Html::label('Size:') ?>
    <?= $parcel->size ?>
</div>

<div>
    <?= Html::label('Price:') ?>
    <?= $parcel->price ?>
</div>

<div>
    <?= Html::label('Category:') ?>
    <?= $parcel->category->name ?>
</div>

<div>
    <?= Html::label('Sender:') ?>
    <?php
        if($parcel->user){
         echo $parcel->user->last_name && $parcel->user->first_name ? $parcel->user->first_name
             . ' '. $parcel->user->last_name : 'Not set';
        }
    ?>
</div>

<div>
    <?= Html::label('Recipient:') ?>
    <?php
        if($parcel->userRecipient){
            echo $parcel->userRecipient->last_name && $parcel->userRecipient->first_name ? $parcel->userRecipient->first_name
                . ' '. $parcel->userRecipient->last_name : 'Not set';
        }
    ?>
</div>

<?= $qr ?>
