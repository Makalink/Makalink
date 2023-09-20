class WordThreePopUpModal {
	constructor(params = {}) {
		let _this          = this;
		this.selector      = document.getElementById('wordthree-confirm-box');
		this.confirmButton = this.selector.querySelector('.btn-yes');
		this.cancelButton  = this.selector.querySelector('.btn-cancel');
		this.messageField  = this.selector.querySelector('.wt-message');

		this.setConfirmBoxParams(params);

		this.confirmButton.addEventListener('click', function (e) {
			_this.confirm();
		});

		this.cancelButton.addEventListener('click', function (e) {
			_this.cancel();
		});

		document.querySelector('.wordthree-confirm-overlay').addEventListener('click', function () {
			_this.close();
		});
	}

	setConfirmBoxParams(params) {
		this.confirmButtonText = params.confirmButtonText ?? this.confirmButtonText ?? wordthree.translations.yes;
		this.cancelButtonText  = params.cancelButtonText ?? this.cancelButtonText ?? wordthree.translations.cancel;
		this.message           = params.message ?? '';
		this.setMessage();
		this.confirmButton.textContent = this.confirmButtonText;
		this.cancelButton.textContent  = this.cancelButtonText;
		this.showCancelButton          = params.showCancelButton ?? this.showCancelButton ?? true;
		if (!this.showCancelButton) {
			this.cancelButton.style.display = 'none';
		}
	}

	setMessage() {
		this.messageField.innerHTML = this.message;
	}

	open(params = {}, callback) {
		this.setConfirmBoxParams(params);
		this.callback               = callback;
		this.selector.style.display = 'block';
		document.body.classList.add('wordthree-confirm-open');
	}

	close() {
		this.selector.style.display = 'none';
		document.body.classList.remove('wordthree-confirm-open');
		this.callback = null;
	}

	confirm() {
		if (this.callback) {
			this.callback(true);
		}
		this.close();
	}

	cancel() {
		if (this.callback) {
			this.callback(false);
		}
		this.close();
	}
}
