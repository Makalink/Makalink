<?php
/**
 * MoWeb3 Utility class.
 *
 * @category   Core
 * @package    MoWeb3
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( '\MoWeb3Constants' ) ) {

	/**
	 * Class containing all utility and helper functions.
	 *
	 * @category Core, Utils
	 * @package  MoWeb3
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3Constants {
		const PANEL_MESSAGE_OPTION                        = 'mo_web3_message';
		const OPTION                                      = 'option';
		const EMAIL                                       = 'email';
		const SOLANA_API                                  = 'https://api.mainnet-beta.solana.com';
		const NFT_PORT_API                                = 'https://api.nftport.xyz/v0/';
		const NFT_PORT_AUTHORIZATION_KEY                  = '50065f45-ec39-449f-af80-018af01a80c2';
		const STYLES_CSS_VERSION                          = '1.0.6';
		const MINT_ADDRESS_FAQ_LINK                       = 'https://faq.miniorange.com/knowledgebase/what-is-mint-address/';
		const ALGORAND_ADDRESS_BYTE_LENGTH                = 36;
		const ALGORAND_CHECKSUM_BYTE_LENGTH               = 4;
		const ALGORAND_ADDRESS_LENGTH                     = 58;
		const NACL_PUBLIC_KEY_LENGTH                      = 32;
		const NACL_HASH_BYTES_LENGTH                      = 64;
		const PHANTOM_BASE58_EXTENSION                    = 'https://pecl.php.net/package/base58';
		const PHANTOM_BASE58_GIT_REPO                     = 'https://github.com/improved-php-library/base58-php-ext';
		const ALCHEMY_MUMBAI_TESTNET_API                  = 'https://polygon-mumbai.g.alchemy.com/nft/v2/';
		const ALCHEMY_API_KEY                             = 'rghTz72tZ6RxRnt0ldBU2dtEfVQYi74w';
		const HASCOIN_AUTHORIZATION_KEY                   = '50065f45-ec39-449f-af80-018af01a80c2';
		const HASCOIN_SOLANA_SIGNATURE_VERIFICATION_API   = 'http://api.hascoin.io/solana/signature-verification';
		const HASCOIN_ETHEREUM_SIGNATURE_VERIFICATION_API = 'http://api.hascoin.io/signature-verification';
		const VERSION                                     = '3.1.0';
		const WEB3_JS_PATH                                = '/classes/common/Web3/resources/js/';
		const WEB3_CSS_PATH                               = '/classes/common/Web3/resources/css/';
		const WEB3_IMG_PATH                               = '/classes/common/Web3/resources/images/';
		const DEMO_SITE                                   = 'https://demo.miniorange.com/wordpress-web3/';
	}
}
