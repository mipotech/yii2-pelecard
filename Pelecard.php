<?php

namespace mipotech\pelecard;

use Yii;
use yii\helpers\Json;

use mipotech\pelecard\requests\ConvertToToken;

class Pelecard extends \yii\base\Component
{
	/**
	 * Return a token based upon the card data
	 *
	 * @param array $params
	 * @return array
	 */
	public function getToken($params = [])
	{
		$request = new ConvertToToken;
		$this->loadRequestParams($request, $params);

		$ret = $this->doPelecardFunction($request, 'services/ConvertToToken');
		return !$this->isSuccess($ret) ? [] : $ret['ResultData'];
	}

	/**
	 * Determine whether the request was sent successfully
	 *
	 * @param array $response The response from Pelecard parsed as an array
	 * @return boolean
	 */
	protected function isSuccess($response)
	{
		return $response['StatusCode'] == '000';
	}

	/**
	 * The load params into the request object
	 *
	 * @param mipotech\pelecard\requests\ApiRequest $requestModel
	 * @param array $params
	 * @return void
	 */
	protected function loadRequestParams(&$requestModel, $params)
	{
		if(is_array($params))
		{
			foreach($params as $key => $value)
			{
				if(property_exists($requestModel, $key))
					$requestModel->$key = $value;
			}
		}
	}

	/**
	 * Do the actual Pelecard API request
	 *
	 * @param
	 * @param
	 * @param
	 * @return array
	 */
	protected function doPelecardFunction($requestModel, $uri, $params = [])
	{
		$endpoint = 'https://gateway20.pelecard.biz/'.$uri;
		$requestModel->user = Yii::$app->params['pelecard']['user'];
		$requestModel->password = Yii::$app->params['pelecard']['password'];
		$requestModel->terminalNumber = Yii::$app->params['pelecard']['terminalNumber'];

		$dataArr = $requestModel->toArray();
		$jsonData = Json::encode($dataArr);
		$ch = curl_init($endpoint);
		curl_setopt_array($ch, [
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS => $jsonData,
			CURLOPT_HTTPHEADER => [
				//'Accept: application/json',
				'Content-Type: application/json; charset=UTF-8',
				'Content-Length:'.strlen($jsonData),
			]
		]);
		$result = curl_exec($ch);
		curl_close($ch);

		$response = $result ? json_decode($result, true) : [];

		$logData = ['endpoint'=>$endpoint,'data'=>$jsonData, 'responseRaw'=>$result];
		if(YII_DEBUG)
			$logData['responseParsed'] = $response;

		// StatusCode=000 -> success
		if (!$this->isSuccess($response)) {
			Yii::error($logData, __CLASS__);
		}
		else {
			Yii::info($logData, __CLASS__);
		}

		// Call our internal error handler if we detect an error
		//if($response['error'] && !YII_DEBUG)
		//	$this->errorHandler($uri, $response);

		return $response;
	}
}
