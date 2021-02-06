<?php
use yii\helpers\Url;
?>
<div class="jumbotron jumbotron-fluid">
    <h1 class="display-4"><?php echo Yii::t('lang','Hi').' <span class="text-capitalize">'.Yii::$app->user->identity->first_name.'</span>,';?></h1>
    <p class="lead"><?php
        echo Yii::t('lang','soon you will activate your new TTS wallet, so you will be able to receive and send tokens (discount coupons) among the activities participating in the project.');
        echo "<br>";
        echo Yii::t('lang','Your electronic wallet will be made secure thanks to a mathematical process that will make the content unreadable.');
        ?>
    </p>
    <hr class="my-4">
    <p class="lead">
        <?php
        echo Yii::t('lang','So, 12 words will be chosen that uniquely identify your wallet. The merit is of cryptography, in particular of the hierarchical deterministic concept, which, thanks to the use of some mathematical functions, allows users, starting from the seed, to recover everything.');
        ?>
    </p>
    <a href="<?php echo Url::to(['/site/logout']); ?>" data-method="post">
        <button class="btn btn-warning btn-lg">
            <i class="fas fa-sign-out-alt"></i> <?php echo Yii::t('lang','Logout');?></button>
    </a>

    <div class="float-right">
        <button type="button" id="stepwizard_step1_next" class="btn btn-primary btn-lg mt-2 next-step" style="font-size: initial;">
            <i class="fa fa-forward"></i> <?php echo Yii::t('lang','Start');?>
        </button>
    </div>

</div>
