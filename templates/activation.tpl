<br>
<div class="text-center">
	<i class="fas fa-exclamation-triangle fa-5x"></i>
	<h3>{$lang['error']}</h3>
	<p>{$lang['text']}</p>
	<br>
	<button id="resend" class="btn btn-default">
		<i class="fas fa-mail"></i>
		{$lang['resend']}
	</button>
</div>

<script type="text/javascript">
	$('.email-verification').hide();
	$('#resend').click(function() {
		$('#resend')
			.html("{$lang['sending']}")
			.attr('disabled', true);

		$.post('clientarea.php', {
			token: '{$token}',
			action: 'resendVerificationEmail'
		}, function () {
			$('#resend')
			.html("{$lang['sent']}")
			.attr('disabled', true);
		});
	})
</script>