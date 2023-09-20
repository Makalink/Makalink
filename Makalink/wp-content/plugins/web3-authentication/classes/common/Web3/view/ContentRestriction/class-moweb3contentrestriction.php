<?php
/**
 * Core
 *
 * Create MoWeb3 Method view Handler.
 *
 * @category   Common, Core
 * @package    MoWeb3\view\SettingsView
 * @author     miniOrange <info@xecurify.com>
 * @license    MIT/Expat
 * @link       https://miniorange.com
 */

namespace MoWeb3\view\ContentRestrictionView;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use MoWeb3\view\ButtonView\MoWeb3View;

if ( ! class_exists( 'MoWeb3\view\ContentRestrictionView\MoWeb3ContentRestriction' ) ) {

	/**
	 * Class to Create MoWeb3 Content Restriction Tab View.
	 *
	 * @category Common, Core
	 * @package  MoWeb3\view\ContentRestrictionView
	 * @author   miniOrange <info@xecurify.com>
	 * @license    MIT/Expat
	 * @link     https://miniorange.com
	 */
	class MoWeb3ContentRestriction {


		/**
		 * Instance of utils class
		 *
		 * @var $util
		 */
		public $util;
		/**
		 * Instance of MoWeb3View class
		 *
		 * @var $button_view
		 */
		public $button_view;
		/**
		 * Constructor
		 */
		public function __construct() {

			$this->util        = new \MoWeb3\MoWeb3Utils();
			$this->button_view = new \MoWeb3\view\ButtonView\MoWeb3View();
			$this->button_view->mo_web3_wp_enqueue();
		}
		/**
		 * Returns the blockchain of the collection if it is saved in the settings
		 *
		 * @param string $blockchain blockchain name.
		 */
		public function select_blockchain( $blockchain ) {
			$result = $this->util->mo_web3_get_option( 'mo_web3_nft_settings' );
			if ( ! $result ) {
				echo 'selected';
			} elseif ( $blockchain === $this->util->mo_web3_get_option( 'mo_web3_nft_settings' )['blockchain'] ) {
				echo 'selected';
			}
		}

		/**
		 * View of content restriction tab
		 */
		public function view() {
			if ( $this->util->mo_web3_get_option( 'mo_web3_nft_settings' ) ) {
				$page_id  = $this->util->mo_web3_get_option( 'mo_web3_nft_settings' )['pageID'];
				$page_url = get_permalink( $page_id );
			} else {
				$page_url = '';
			}
			?>	
			<div class="mo_support_layout container prem-info" id="mo_web3_nft_form">
			<?php
				$this->util->render_premium_info_ui( 'NFT based Content restriction of pages is available in the premium version of the plugin.','https://developers.miniorange.com/docs/wordpress-web3/features/token-gating' );
			?>
				<div class="row">
						<div class="col-11">
							<h1>NFT Content Restriction</h1><br>
						</div>                                        
					</div>
				<div class="row">
					<div class="col-11">
						<form method="post" action="">
					<?php
					wp_nonce_field( 'mo_web3_content_restriction', 'mo_web3_content_restriction_nonce' );

					?>
					<div class="form-group row mb-3">

						<div class="col-sm-4">
							<label for="pageUrl">Page URL</label>
						</div>

						<div class="col-sm-8">

						<?php
						echo '<input type="text" class="form-control" id="pageUrl" name="pageUrl" placeholder="Enter Page URL" required
								value ="' . esc_url_raw( $page_url ) . '"/>';
						?>
						</div>

					</div>


					<div class="form-group mb-3 row">

						<div class="col-sm-4">
							<label>Blockchain</label>
						</div>

						<div class="col-sm-8">
							<select  class="form-control" id="mo_web3_blockchain" name="blockchain" onchange="changeFieldDynamically('dynamic_label')">
								<option <?php $this->select_blockchain( 'Ethereum' ); ?> value="Ethereum">Ethereum</option>
								<option <?php $this->select_blockchain( 'Goerli' ); ?> value ="Goerli" >Goerli</option>
								<option <?php $this->select_blockchain( 'Polygon' ); ?> value ="Polygon" >Polygon</option>
								<option <?php $this->select_blockchain( 'PolygonMumbai' ); ?> value ="PolygonMumbai" >Polygon Mumbai</option>
								<option <?php $this->select_blockchain( 'Binance' ); ?> value ="Binance" >Binance(BNB)</option>
								<optgroup label="Solana">
									<option <?php $this->select_blockchain( 'solanaMintAddress' ); ?> value="solanaMintAddress">Solana(Mint Address)</option>
									<option <?php $this->select_blockchain( 'solanaCollectionID' ); ?> value="solanaCollectionID">Solana(Collection ID)</option>
									<option <?php $this->select_blockchain( 'solanaCollectionKey' ); ?> value="solanaCollectionKey">Solana(Collection Key)</option>
								</optgroup>
							</select>
						</div>
					</div>

					<div class="form-group row mb-3">

						<div class="col-sm-4" >
							<div >
								<label id="dynamic_label" for="contractAddress">Contract Address</label>
								<a id="dynamic_label_info" href="#" >[know more]</a>
							</div>
						</div>

						<div class="col-sm-8">
							<?php
							if ( $this->util->mo_web3_get_option( 'mo_web3_nft_settings' ) ) {
								$contract_address = $this->util->mo_web3_get_option( 'mo_web3_nft_settings' )['contractAddress'];
							} else {
								$contract_address = '';
							}
							echo '<input type="text" class="form-control" id="contractAddress" name="contractAddress" placeholder="Contract Address" required
								value ="' . esc_attr( $contract_address ) . '"/>';
							?>
						</div>

					</div>


					<div class="form-group row mb-3">

						<div class="col-sm-4">
							<label for="contractAddress">Add More </label>
						</div>

						<div class="col-sm-8">
							<img width="30px"  class="cursor-disabled" src= "<?php echo esc_url( MOWEB3_URL ) . esc_url( \MoWeb3Constants::WEB3_IMG_PATH ) . 'add-plus-icon.svg'; ?>"/>
						</div>

					</div>
					<div class="row"> 
						<div class="col-sm-4">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>

						<div class="col-sm-6">
							<button id="nftTestConfig" type="button" class="btn btn-primary" data-toggle="modal" data-target="#moweb3_address_modal">Test Configuration</button>
						</div>

					</div>
				</form>

				</div>
				</div>



				<button type="button" class="btn btn-primary" id="moweb3NftTestConfig"  style="display:none"  data-toggle="modal" data-target="#moweb3_address_modal">
					Test Configuration
				</button>

				<div class="modal fade" id="moweb3_address_modal" style="opacity:100%;display:none;" aria-labelledby="moweb3_address_modal_label" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">

							<div class="modal-header">
								<h5 class="modal-title" id="moweb3_test_modal_label">Enter Test Wallet Address</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<form>

								<div class="modal-body">
									<div class="form-group mb-3 row"  id="walletAddressWrapper">

										<div class="col-sm-4">
											<label for="contractAddress">Wallet Address</label>
										</div>

										<div class="col-sm-8">
											<input type="text" class="form-control" id="walletAddress" name="walletAddress" placeholder="Wallet Address"  required>
										</div>									
									</div>
								</div>

								<div class="modal-footer">
									<div class="row" >

										<div class="col-sm-6">
											<button type="button" class="btn btn-primary"  id="walletAddressModal">Submit</button>
										</div>
										<div class="col-sm-6">
											<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
										</div>

									</div>
								</div>

							</form>

						</div>
					</div>

				</div>



				<button type="button" class="btn btn-primary" id="moweb3_display_modal"  style="display:none"  data-toggle="modal" data-target="#moweb3_test_modal">
					Test Configuration
				</button>


				<div class="modal fade" id="moweb3_test_modal" style="opacity:100%;display:none;" aria-labelledby="moweb3_test_modal_label" aria-hidden="true">
					<div class="modal-dialog" style="min-width:700px">
						<div class="modal-content">

							<div class="modal-header">
								<h5 class="modal-title" id="moweb3_test_modal_label">Test Results: Successful</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<div class="modal-body">
								<div class="d-flex justify-content-center">
									<img width="30%"  src= "<?php echo esc_url( MOWEB3_URL ) . esc_url( \MoWeb3Constants::WEB3_IMG_PATH ) . 'success-green-check-mark.svg'; ?>"/>
								</div>
								<table class="table table-striped">

									<thead>
										<tr>
											<th scope="col">Attribute Name</th>
											<th scope="col">Attribute Value</th>
										</tr>
									</thead>


									<tbody>
										<tr>
										<th scope="row">No. Of Token</th>
										<td id="numToken"></td>
										</tr>
									</tbody>

									<tbody>
										<tr>
										<th scope="row">Status</th>
										<td id="pageLink"></td>
										</tr>
									</tbody>

									<tbody>
										<tr>
										<th id="dynamic_th" scope="row">Contract Address</th>
										<td id="nftContractAddress"></td>
										</tr>
									</tbody>


								</table>

							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>

						</div>
					</div>
				</div>
			</div>		
			<!-- it is a hidden button -->
			<button type="button" id="solanaCollectionIDButton" class="btn btn-primary" style="display:none" data-toggle="modal" data-target="#solanaCollectionIDModal">
			Solana CollectionID Hidden Button
			</button>

			<!-- Modal -->
			<div class="modal fade" id="solanaCollectionIDModal" style="opacity:100%" tabindex="-1" role="dialog" aria-labelledby="solanaCollectionIDModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Get Solana Collection ID or Collection Key</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form>
								<div class="modal-body">
									<div class="form-group mb-3 row">

										<div class="col-sm-4">
											<label for="contractAddress">Mint Address</label>
											<a id="dynamic_label_info" href="<?php echo esc_url_raw( \MoWeb3Constants::MINT_ADDRESS_FAQ_LINK ); ?>" target="_blank" >[know more]</a>
										</div>

										<div class="col-sm-8">
											<input type="text" class="form-control" id="solanaMintAddress" aria-describedby="emailHelp" placeholder="Enter Token Address/ Mint Address">
										</div>
									</div>
									<div style="display:none" id="solanaDataContainer">
										<div class="form-group mb-3 row">
											<div class="col-sm-4">
												<label for="contractAddress">Collection ID</label>
											</div>
											<div class="col-sm-8">
												<p id="showCollectionID"></p>
											</div>
										</div>
										<div class="form-group mb-3 row">
											<div class="col-sm-4">
												<label for="contractAddress">Collection Key</label>
											</div>
											<div class="col-sm-8">
												<p id="showCollectionKey"></p>
											</div>
										</div>
									</div>
								</div>

								<div class="modal-footer">
									<div class="row">
										<div class="col-sm-6">
											<button type="button" class="btn btn-primary"  id="getCollectionKey">Submit</button>
										</div>
										<div class="col-sm-6">
											<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
										</div>									
									</div>
								</div>

							</form>
						</div>
					</div>
				</div>
			</div>
			<script>


			document.getElementById("getCollectionKey").addEventListener("click",async ()=>{

				let mintAddress = document.getElementById("solanaMintAddress")?.value;

				let getSolanaCollectionKey={
					'action':'type_of_request',
					'request':'getSolanaTokenDetails',
					'fieldValue':mintAddress,
					'fieldKey':'solanaMintAddress',
					'mo_web3_verify_nonce':wp_nonce
				};


				await jQuery.post(ajaxurl,getSolanaCollectionKey,function(response) {
					response = JSON.parse(response);
					let collectionKey =response?.nft?.collection_id;
					let collectionID  =response?.nft?.on_chain_collection_key;

					document.getElementById("solanaDataContainer").style.display = 'block';
					document.getElementById("showCollectionID").innerHTML = `<b>${collectionKey}</b>`;
					document.getElementById("showCollectionKey").innerHTML = `<b>${collectionID}</b>`;
				});			
			});	  

			document.getElementById("dynamic_label_info").addEventListener("click",()=>{

				let blockchain = document.getElementById("mo_web3_blockchain").value;				
				if("solanaMintAddress"==blockchain){
					let faqLink = "<?php echo esc_js( \MoWeb3Constants::MINT_ADDRESS_FAQ_LINK ); ?>";
					window.open(faqLink);

				}else if("solanaCollectionID"==blockchain || "solanaCollectionKey"==blockchain){
					document.getElementById("solanaDataContainer").style.display = 'none';
					document.getElementById("solanaCollectionIDButton").click();

				}else{
					alert("Contract Address");
				}
			});								
			function changeFieldDynamically(feildId='dynamic_label') {
				let blockchain = document.getElementById("mo_web3_blockchain").value;
				if("solanaMintAddress"==blockchain){

					document.getElementById(feildId).innerHTML = 'Mint Address';
					document.getElementById("contractAddress").placeholder = 'Mint Address';
				}else if("solanaCollectionID"==blockchain){
					document.getElementById(feildId).innerHTML = 'Collection ID';
					document.getElementById("contractAddress").placeholder = 'Collection ID';

				}else if("solanaCollectionKey"==blockchain){
					document.getElementById(feildId).innerHTML = 'Collection Key';
					document.getElementById("contractAddress").placeholder = 'Collection Key';

				}else{
					document.getElementById(feildId).innerHTML = 'Contract Address';
					document.getElementById("contractAddress").placeholder = 'Contract Address';

				}
			}


			window.addEventListener('load', changeFieldDynamically('dynamic_label'));


			document.getElementById("walletAddressModal").addEventListener("click", async () => {
				let pageURL = "";
				let contractAddress = "";
				let blockchain = document.getElementById("mo_web3_blockchain").value;
				changeFieldDynamically('dynamic_th');

			<?php
			if ( $this->util->mo_web3_get_option( 'mo_web3_nft_settings' ) ) {
				?>

					pageURL         = "<?php echo esc_attr( get_permalink( $this->util->mo_web3_get_option( 'mo_web3_nft_settings' )['pageID'] ) ); ?>";
					contractAddress = "<?php echo esc_attr( $this->util->mo_web3_get_option( 'mo_web3_nft_settings' )['contractAddress'] ); ?>";
					blockchain      = "<?php echo esc_attr( $this->util->mo_web3_get_option( 'mo_web3_nft_settings' )['blockchain'] ); ?>";
				<?php } ?>  
				let walletAddress   = document.getElementById('walletAddress').value;
				let tokenBalance    = await checkAndShowNft(walletAddress,contractAddress,blockchain,pageUrl);
				let msgToDisplay;

				if(tokenBalance>0){
					msgToDisplay = '<p style="color:green">Access Allowed</p>';
				}else{
					msgToDisplay = '<p style="color:red">Access Denied</p>';
				}

				document.getElementById("numToken").innerText = BigInt(tokenBalance);
				document.getElementById("pageLink").innerHTML = msgToDisplay;
				document.getElementById("nftContractAddress").innerText = contractAddress;
				document.getElementById('moweb3_display_modal').click();

			});

			</script><?php
		}
	}
}
?>
