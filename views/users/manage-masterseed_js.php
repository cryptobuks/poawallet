<?php


$manageSeed = <<<JS

$(function () {
    'use strict';

    // leggo lo status attuale della tabella pin
    var masterseedSlider = document.querySelector('.masterseedSlider');
    masterseedSlider.addEventListener('click', function(){
        $('#masterSeedModal').modal({
			  backdrop: 'static',
			  keyboard: false
		});

    });

    // INTERCETTA IL PULSANTE indietro SULLA PRIMA SCHERMATA e reset pulsanti
    var masterseedSliderBack1 = document.querySelector('.masterseedSliderBack1');
    masterseedSliderBack1.addEventListener('click', function(){
        $('.masterseedSlider').removeClass('checked');
    });

    // INTERCETTA IL PULSANTE indietro SULLA SECONDA SCHERMATA e reset pulsanti
    var masterseedSliderBack2 = document.querySelector('.masterseedSliderBack2');
    masterseedSliderBack2.addEventListener('click', function(){
        $('.masterseedSlider').removeClass('checked');
    });

    // INTERCETTA IL PULSANTE indietro SULLA SECONDA SCHERMATA e reset pulsanti
    var masterseedSliderBack3 = document.querySelector('.masterseedSliderBack3');
    masterseedSliderBack3.addEventListener('click', function(){
        $('.masterseedSlider').removeClass('checked');
    });

    // read seed from dbx and decrypt
    var masterSeedButton = document.querySelector('#showMasterSeed');
	masterSeedButton.addEventListener('click', function() {
		$('#masterSeed').html(spinner);
		readAllData('mseed').then(function(data) {
			console.log('[Master Seed IndexedDB]',data);
			if (typeof data[0] !== 'undefined') {
				$.ajax({
					url: yiiOptions.decryptURL,
					type: "POST",
					data: {'cryptedseed': data[0].cryptedseed},
					dataType: "json",
					success:function(data){
						$('#masterSeed').html(data.decryptedseed);
					},
					error: function(j){
						console.log('error',j);
					}
				});

			}else{
				$('#masterSeed').text('Backup not found!');
			}
		})
	});








});






JS;
$this->registerJs(
    $manageSeed,
    yii\web\View::POS_READY, //POS_END
    'manageSeed'
);

?>
