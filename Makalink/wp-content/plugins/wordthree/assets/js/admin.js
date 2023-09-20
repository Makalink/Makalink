"use strict";
(function ($, w, d) {
	const WordThreeAdmin = {
		copyShortCodeButton: $('.copy-shortcode-btn'),
		init: function () {
			const _self = this;
			this.copyShortCodeButton.on('click', function () {
				let target = $(this).data('target-copy');
				let text   = $(target).val();
				_self.copyShortcodeToClipboard(text);
				let tootip = $('.tooltiptext', this);
				tootip.text(tootip.data('text-copied'));
			});

			this.copyShortCodeButton.on('mouseout', function () {
				let tootip = $('.tooltiptext', this);
				tootip.text(tootip.data('text-original'));
			});
		},
		copyShortcodeToClipboard: function (text) {
			navigator.clipboard.writeText(text);
		}
	};

	WordThreeAdmin.init();
})(jQuery, window, document)
