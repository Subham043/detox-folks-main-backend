<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

				<head>
								<meta charset="utf-8">
								<meta name="viewport" content="width=device-width, initial-scale=1">
								<link rel="icon" type="image/png" sizes="16x16" href="{{ asset("payment/logo.png") }}">

								<title>Parcelcounter - Payment Failed</title>

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
																<div class="form-holder">
																				<div class="form-content">
																								<div class="form-items">
																												<div class="website-logo-inside mb-3 pt-5 text-center">
																																<a href="{{ config("app.main_url") . "/account/orders" }}">
																																				<div class="logo">
																																								<img src="{{ asset("payment/logo.png") }}" />
																																				</div>
																																</a>
																												</div>
																												<p class="text-dark">Your Payment Failed. You can close this window and try again.</p>
																								</div>
																				</div>
																</div>
												</div>
								</div>
				</body>

</html>
