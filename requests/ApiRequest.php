<?php

/**
 * @license GNU GPL v3.0
 * @version 1.0
 */

namespace mipotech\pelecard\requests;

use Yii;

/**
 * ApiRequest represents the base request upon which all other requests are to be build
 *
 * @author Chaim Leichman, MIPO Technologies Ltd
 * @version 1.0
 */
abstract class ApiRequest extends \yii\base\Model
{
	/**
	 * @var string $userName Sales Channel User Name
	 */
	public $user;

	/**
	 * @var string $password Sales Channel Password
	 */
	public $password;

	/**
	 * @var string $terminalNumber
	 */
	public $terminalNumber;
}
