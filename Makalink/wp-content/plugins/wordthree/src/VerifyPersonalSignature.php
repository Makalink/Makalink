<?php


namespace WordThree\Metamask;

use Elliptic\Curve\BaseCurve\Point;
use Elliptic\EC;
use kornrunner\Keccak;

class VerifyPersonalSignature {

	/**
	 * Verify if the signature retrieved from the user is genuine.
	 *
	 * @param $message string
	 * @param $signature string
	 * @param $address string
	 * @return bool
	 */
	public static function verify( $message, $signature, $address) {
		try {
			$msglen = strlen($message);
			$hash   = Keccak::hash("\x19Ethereum Signed Message:\n{$msglen}{$message}", 256);
			$sign   = [
				'r' => substr($signature, 2, 64),
				's' => substr($signature, 66, 64)
			];
			$recid  = ord(hex2bin(substr($signature, 130, 2))) - 27;
			if (( $recid & 1 ) != $recid ) {
				return false;
			}

			$ec = new EC('secp256k1');

			$pubkey = $ec->recoverPubKey($hash, $sign, $recid);
			return static::pubKeyToAddress($pubkey) == $address;
		} catch (\Exception $e) {
			return false;
		}
	}

	/**
	 * Transforms the public key to a hexadecimal address.
	 *
	 * @param $pubkey Point
	 * @return string
	 * @throws \Exception
	 */
	public static function pubKeyToAddress( $pubkey) {
		return '0x' . substr(Keccak::hash(substr(hex2bin($pubkey->encode('hex')), 1), 256), 24);
	}
}
