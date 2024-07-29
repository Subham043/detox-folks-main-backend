<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

				<head>
								<meta charset="utf-8">
								<meta name="viewport" content="width=device-width, initial-scale=1">

								<title>Parcelcounter - CashFree Payment Gateway</title>
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

																</div>

												</div>
								</div>
				</body>
				<script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
				<script type="text/javascript" nonce="{{ csp_nonce() }}">
								const cashfree = Cashfree({
												mode: "{{ config("app.cashfree.mode") }}" //or production
								});
								let checkoutOptions = {
												paymentSessionId: "{{ $paymentSessionId }}",
												redirectTarget: "_self" //optional ( _self, _blank, or _top)
								}

								cashfree.checkout(checkoutOptions)
				</script>

</html>
