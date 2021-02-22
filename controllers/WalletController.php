<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\HttpException;
use yii\filters\VerbFilter;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

use app\models\BoltTokens;
use app\models\search\BoltTokensSearch;
use app\models\BoltWallets;
use app\models\BoltSocialusers;
// use app\models\SendTokenForm;
// use app\models\WizardWalletForm;
// use app\models\PushSubscriptions;

use yii\bootstrap4\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;

// use Web3\Web3;
// use Web3\Contract;
// use Web3p\EthereumTx\Transaction;
// use Nullix\CryptoJsAes\CryptoJsAes;

// Yii::$classMap['settings'] = Yii::getAlias('@packages').'/settings.php';
// // Yii::$classMap['webapp'] = Yii::getAlias('@packages').'/webapp.php';
use app\components\WebApp;

class WalletController extends Controller
{


	public function beforeAction($action)
	{
    	$this->enableCsrfValidation = false;
    	return parent::beforeAction($action);
	}


	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => [
					'index',
				],
				'rules' => [

					[
						'allow' => true,
						'actions' => [
							'index',
						],
						'roles' => ['@'],
					],
				],
			],
			];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}


	private function loadSocialUser()
	{
		$user = BoltSocialusers::find()
 	     		->andWhere(['id_user'=>Yii::$app->user->id])
 	    		->one();

		return $user;
	}



	/**
	 * Lists wallet dashboard page
	 */
	public function actionIndex()
	{
		$fromAddress = BoltWallets::find()->userAddress(Yii::$app->user->id);

		if (NULL === $fromAddress){
			$session = Yii::$app->session;
			$string = Yii::$app->security->generateRandomString(32);
			$session->set('token-wizard', $string );

			return $this->redirect(['wizard/index','token' => $string]);
		}

		$searchModel = new BoltTokensSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->setPagination(['pageSize' => 5]);
		$dataProvider->sort->defaultOrder = ['invoice_timestamp' => SORT_DESC];
		$dataProvider->query
					->orwhere(['=','to_address', $fromAddress])
					->orwhere(['=','from_address', $fromAddress]);

		return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'fromAddress' => $fromAddress,
				'balance' => Yii::$app->Erc20->Balance($fromAddress),
				'userImage' => $this->loadSocialUser()->picture,
		]);
	}



	private static function json ($data)
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		return $data;
	}

	public function actionCrypt()
	{
		$data = [
			'cryptedpass' => isset($_POST['pass']) ? WebApp::encrypt($_POST['pass']) : '',
			'cryptedseed' => isset($_POST['seed']) ? WebApp::encrypt($_POST['seed']) : '',
			'cryptediduser' => WebApp::encrypt(Yii::$app->user->id),
		];

		return $this->json($data);
	}

	public function actionDecrypt()
	{
		$data = [
			'decrypted' => isset($_POST['pass']) ? WebApp::decrypt($_POST['pass']) : '',
			'decryptedseed' => isset($_POST['cryptedseed']) ? WebApp::decrypt($_POST['cryptedseed']) : '',
			'decryptediduser' => isset($_POST['cryptediduser']) ? WebApp::decrypt($_POST['cryptediduser']) : '',

		];
		return $this->json($data);
	}






}
