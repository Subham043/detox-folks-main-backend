<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

				<head>
								<meta charset="utf-8">
								<meta name="viewport" content="width=device-width, initial-scale=1">

								<title>Parcelcounter - PAYU Payment Gateway</title>
								<link rel="icon" type="image/png" sizes="16x16" href="{{ asset("payment/logo.png") }}">

								@vite(["resources/admin/css/main.css"])
								<link rel="stylesheet" type="text/css" href="{{ asset("payment/iofrm-style.css") }}">
								<link rel="stylesheet" type="text/css" href="{{ asset("payment/iofrm-theme11.css") }}">

								<style>
												body,
												.form-body,
												.form-content {
																background-color: #eee;
												}
								</style>

				</head>

				<body class="antialiased">
								<div class="form-body">
												<div class="row">

																<div class="col-lg-12">
																				<div class="website-logo-inside mb-0 pt-5 text-center">
																								<a href="#">
																												<div class="logo">
																																<img src="{{ asset("payment/logo.png") }}" />
																												</div>
																								</a>
																				</div>
																				<div class="p-2 text-center">
																								<div class="mt-3">
																												<h5 class="mb-3">Please wait while we process your payment</h5>
																												<div class="hstack justify-content-center gap-2">
																																<div class="spinner-border text-dark" role="status"></div>
																												</div>
																								</div>
																				</div>
																				<form action="{{ $action }}" method="post" name="payuForm" nonce="{{ csp_nonce() }}"><br />
																								<input type="hidden" name="key" value="{{ $MERCHANT_KEY }}" /><br />
																								<input type="hidden" name="hash" value="{{ $hash }}" /><br />
																								<input type="hidden" name="txnid" value="{{ $txnid }}" /><br />
																								<input type="hidden" name="amount" value="{{ $amount }}" /><br />
																								<input type="hidden" name="firstname" id="firstname" value="{{ $name }}" /><br />
																								<input type="hidden" name="email" id="email" value="{{ $email }}" /><br />
																								<input type="hidden" name="productinfo" value="Webappfix"><br />
																								<input type="hidden" name="surl" value="{{ $successURL }}" /><br />
																								<input type="hidden" name="furl" value="{{ $failURL }}" /><br />
																								<input type="hidden" name="service_provider" value="payu_paisa" /><br />
																								<?php if(!$hash) { ?>
																								<input type="submit" value="Submit" />
																								<?php } ?>
																				</form>

																</div>

												</div>
								</div>
				</body>
				<script type="text/javascript" nonce="{{ csp_nonce() }}">
								function submitPayuForm() {
												var payuForm = document.forms.payuForm;
												payuForm.submit();
								}
								window.onload = submitPayuForm;
				</script>

</html>
