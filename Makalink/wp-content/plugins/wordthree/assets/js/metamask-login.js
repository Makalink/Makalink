/* global wordthree */
class WordThreeMetamaskLogin {
	constructor() {
		this.metamask                = new WordThreeMetamask();
		this.confirmBox              = new WordThreePopUpModal();
		this.apiUrl                  = wordthree.apiUrl;
		this.metamaskLoginButtons    = document.querySelectorAll('.wordthree-metamask-login');
		this.metamaskRegisterButtons = document.querySelectorAll('.wordthree-metamask-register');
		this.metamaskLinkButtons     = document.querySelectorAll('.wordthree-metamask-link');
		this.metamaskUnlinkButton    = document.querySelector('.wordthree-metamask-unlink');
		this.metamaskUnlinkButtons   = document.querySelectorAll('.wordthree-metamask-unlink');
	}

	fetch(url, data = {}) {
		return fetch(url, {
			method: 'POST',
			headers: {
				"Content-Type": "application/json",
				"X-WP-Nonce": wordthree.nonce
			},
			body: JSON.stringify(data)
		});
	}

	signTokenMessage() {
		return this.metamask.getAccount().then(publicAddress => {
			return this.getToken(publicAddress).then(response => {
				if (!response.success) {
					throw Error(response.message);
				}

				return this.metamask.handleSignMessagePersonal(response.message, publicAddress).then(signature => {
					return {publicAddress, signature};
				});
			});
		});
	}

	async getToken(address) {
		const tokenUrl = this.apiUrl + wordthree.restRoutes.tokenUrl;
		let response   = await this.fetch(tokenUrl, {address});

		return response.json();
	}

	async handleLogin(publicAddress, signature) {
		const loginUrl = this.apiUrl + wordthree.restRoutes.loginUrl;
		let response   = await this.fetch(loginUrl, {address: publicAddress, signature: signature});

		return response.json();
	}

	async handleRegister(publicAddress, signature) {
		const registerUrl = this.apiUrl + wordthree.restRoutes.registerUrl;
		let response      = await this.fetch(registerUrl, {address: publicAddress, signature: signature});

		return response.json();
	}

	async handleLinkAccount(publicAddress, signature) {
		const linkUrl = this.apiUrl + wordthree.restRoutes.linkUrl;
		let response  = await this.fetch(linkUrl, {address: publicAddress, signature: signature});

		return response.json();
	}

	async handleUnlink(publicAddress, signature) {
		const unlinkUrl = this.apiUrl + wordthree.restRoutes.unlinkUrl;
		let response    = await this.fetch(unlinkUrl, {address: publicAddress, signature: signature});
		/*if (!response.ok) {
			throw Error(response.statusText);
		}*/
		return response.json();
	}

	loginUser() {
		return this.signTokenMessage().then(r => {
			return this.handleLogin(r.publicAddress, r.signature).then(response => {
				if (!response.success) {
					throw Error(response.message);
				}
				return response.message;
			})
		});
	}

	registerUser() {
		return this.signTokenMessage().then(r => {
			return this.handleRegister(r.publicAddress, r.signature).then(response => {
				if (!response.success) {
					throw Error(response.message);
				}
				return response.message;
			})
		});
	}

	link() {
		return this.signTokenMessage().then(r => {
			return this.handleLinkAccount(r.publicAddress, r.signature).then(response => {
				if (!response.success) {
					throw Error(response.message);
				}
				return response.message;
			});
		});
	}

	unlink() {
		return this.signTokenMessage().then(r => {
			return this.handleUnlink(r.publicAddress, r.signature).then(response => {
				if (!response.success) {
					throw Error(response.message);
				}

				return response.message;
			});
		});
	}

	init() {
		this.initEvents();
	}

	initEvents() {
		this.createLoginEvent();
		this.createRegisterEvent();
		this.createUnlinkEvent();
		this.createLinkEvent();
	}

	createLoginEvent() {
		this.metamaskLoginButtons.forEach((button) => {
			button.addEventListener('click', async (e) => {
				if (!this.metamask.checkMetamaskActive()) {
					this.showInstallMetamaskPopup();
					return;
				}

				this.loginUser().then(message => {
					this.openConfirmBox(message, (confirm) => {
						if (confirm) {
							if (button.dataset.redirectUrl) {
								location.href = button.dataset.redirectUrl;
								return;
							}
							location.reload();
						}
					})
				}).catch(err => this.openConfirmBox(err.message));
			});
		});
	}

	createRegisterEvent() {
		this.metamaskRegisterButtons.forEach((button) => {
			button.addEventListener('click', async (e) => {
				if (!this.metamask.checkMetamaskActive()) {
					this.showInstallMetamaskPopup();
					return;
				}

				this.registerUser().then(message => {
					this.openConfirmBox(message, (confirm) => {
						if (confirm) {
							if (button.dataset.redirectUrl) {
								location.href = button.dataset.redirectUrl;
								return;
							}
							location.reload();
						}
					});
				}).catch(err => this.openConfirmBox(err.message));
			});
		});
	}

	createLinkEvent() {
		this.metamaskLinkButtons.forEach(button => {
			button.addEventListener('click', (e) => {
				if (!this.metamask.checkMetamaskActive()) {
					this.showInstallMetamaskPopup();
					return;
				}

				this.link().then(message => {
					this.openConfirmBox(message, (confirm) => {
						if (confirm) {
							location.reload();
						}
					});
				}).catch(err => this.openConfirmBox(err.message));
			});
		});
	}

	createUnlinkEvent() {
		this.metamaskUnlinkButtons.forEach(button => {
			button.addEventListener('click', (e) => {
				if (!this.metamask.checkMetamaskActive()) {
					this.showInstallMetamaskPopup();
					return;
				}

				this.unlink().then(message => {
					this.openConfirmBox(message, (confirm) => {
						if (confirm) {
							location.reload();
						}
					});
				}).catch(err => this.openConfirmBox(err.message));
			});
		});
	}

	openConfirmBox(message, callback) {
		this.confirmBox.open({
			message: message,
			confirmButtonText: wordthree.translations.ok.toUpperCase(),
			showCancelButton: false
		}, callback);
	};

	showInstallMetamaskPopup() {
		this.confirmBox.open({
			message: wordthree.translations.metamask_required_login,
			confirmButtonText: wordthree.translations.install_now,
			cancelButtonText: wordthree.translations.cancel,
			showCancelButton: true
		}, (confirm) => {
			if (confirm) {
				window.open('https://metamask.io', '_blank');
			}
		});
	}
}

(function (d, w) {
	const metaMaskLogin = new WordThreeMetamaskLogin();
	metaMaskLogin.init();
})(document, window);
