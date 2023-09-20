class WordThreeMetamask {
	constructor() {

	}

	async getAccount() {
		let accounts = await this.web3.givenProvider.request({method: 'eth_requestAccounts'});
		return accounts[0];
	}

	async handleSignMessagePersonal(message, publicAddress) {
		return await this.web3.eth.personal.sign(message, publicAddress);
	}

	checkMetamaskActive() {
		if (!window.ethereum || !ethereum.isMetaMask) {
			return false;
		}

		this.web3 = new Web3(window.ethereum);
		return true;
	}
}
