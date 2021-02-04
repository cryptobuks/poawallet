<?php
use yii\helpers\Url;
use Da\QrCode\QrCode;

$this->title = Yii::$app->id;

$qrCode = (new QrCode($fromAddress))
    ->setSize(200)
    ->setMargin(5)
    // ->useForegroundColor(51, 153, 255);
    ->useForegroundColor(11, 21, 31);

?>

<main class="margin mt-0">
    <div class="dash-balance">

        <div class="card text-center">
            <?php echo '<img class="card-img-top" src="' . $qrCode->writeDataUri() . '">'; ?>
            <div class="card-header">
                <?= Yii::t('lang','Click to copy the address in the clipboard') ?>
            </div>
          <div class="card-body">
            <h5 class="card-title"><?= Yii::t('lang','NFC Secure Transactions') ?></h5>
            <button class="btn btn-warning mt-2 btn-lg btn-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 18H4V4h16v16zM18 6h-5c-1.1 0-2 .9-2 2v2.28c-.6.35-1 .98-1 1.72 0 1.1.9 2 2 2s2-.9 2-2c0-.74-.4-1.38-1-1.72V8h3v8H8V8h2V6H6v12h12V6z"/>
                </svg> <?php echo Yii::t('lang','NFC receive');?>
            </button>
          </div>
          <div class="card-footer text-muted text-break">
            <?php echo $fromAddress; ?>
          </div>
        </div>

    </div>
</main>