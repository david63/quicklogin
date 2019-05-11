;(function($) {
	$(document).ready(function() {
		//var $button = $('.icon-logout a'),
		var $button	= $('a[href*="ucp.php?mode=login"]'),
			ql_bg 	= '#quick-login-bg',
			ql_pnl 	= '#quick-login-panel',
			pS_bg 	= '#darkenwrapper';

		if ($(pS_bg).length) {
			ql_bg = pS_bg;
		}

		$button.click(function(e){
			e.preventDefault();
			$(ql_bg + ', ' + ql_pnl).fadeIn(300);
		});
		
		$(ql_bg + ', #quick-login-panel .close').click(function () {
			$(ql_bg + ', ' + ql_pnl).fadeOut(300);
		})
	});
})(jQuery);
