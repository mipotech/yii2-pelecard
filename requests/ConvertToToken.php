<?php

/**
 * @license GNU GPL v3.0
 * @version 1.0
 */

namespace mipotech\pelecard\requests;

/**
 * ConvertToToken represents a function to convert the credit card data to a string.
 *
 *
 * @author Rebecca Attali, MIPO Technologies Ltd
 * @version 1.0
 */

class ConvertToToken extends ApiRequest
{
	/**
	 * @var string $creditCard
	 */
	public $creditCard;

	/**
	 * @var string $creditCardDateMmYy valid date in MMYY format
	 */
	public $creditCardDateMmYy;

	/**
	 */

	public $addFourDigits = 'false';
}
