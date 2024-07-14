<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

				<head>
								<meta charset="utf-8">
								<meta name="viewport" content="width=device-width, initial-scale=1">

								<title>Parcelcounter - Razorpay Payment Gateway</title>
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
																				<div class="p-2 text-center" id="payment_failed" style="display: none;">
																								<div class="mt-3">
																												<h5 class="mb-3">Oops payment failed!</h5>
																												<p class="text-dark mb-4"> The transfer was not successfully received by us.</p>
																												<div class="hstack justify-content-center gap-2">
																																<button type="button" class="btn btn-dark">Cancel</button>
																																<button id="try-payment-btn" class="btn btn-success">Try Again</button>
																												</div>
																								</div>
																				</div>

																				<div class="p-2 text-center" style="display: none;" id="payment_cancelled">
																								<div class="mt-3 pt-4">
																												<h5>Uh oh, You cancelled the payment!</h5>
																												<p class="text-dark"> The payment was not successfully received by us.</p>
																												<!-- Toogle to second dialog -->
																												<button id="make-payment-btn" class="btn btn-warning">Make Payment</button>
																								</div>
																				</div>

																				<div class="p-2 text-center" style="display: none;" id="payment_success">
																								<div class="mt-3">
																												<h5 class="mb-3">Your Transaction was Successfull !</h5>
																												<p class="text-dark mb-4"> Please wait till we verify your payment. Do not refresh the
																																browser unless we have completed the verification.</p>
																												<div class="hstack justify-content-center gap-2">
																																<div class="spinner-border text-dark" role="status"></div>
																												</div>
																								</div>
																				</div>

																</div>

												</div>
								</div>
				</body>
				<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
				<script src="{{ asset("admin/js/pages/axios.min.js") }}"></script>
				<script type="text/javascript" nonce="{{ csp_nonce() }}">
								document.getElementById('make-payment-btn').addEventListener('click', setPrice);
								document.getElementById('try-payment-btn').addEventListener('click', setPrice);

								var options;

								function setPrice() {
												options = {
																"key": "{{ config("app.razorpay.key") }}", // Enter the Key ID generated from the Dashboard
																"amount": parseFloat({{ $order->total_price }}) *
																				100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
																"order_id": "{{ $order->payment->razorpay_order_id }}",
																"currency": "INR",
																"callback_url": '{{ route("verify_razorpay_payment", $order->id) }}',
																"redirect": true,
																"name": "Parcelcounter",
																"description": "Order Transaction",
																"image": "{{ asset("payment/logo.png") }}",
																"config": {
																				"display": {
																								"blocks": {
																												"banks": {
																																"name": 'Pay via UPI',
																																"instruments": [{
																																				"method": 'upi'
																																}],
																												},
																								},
																								"sequence": ['block.banks'],
																								"preferences": {
																												"show_default_blocks": false,
																								},
																				},
																},
																//This is a sample Order ID. Pass the `id` obtained in the response of Step 1
																"handler": function(response) {
																				document.getElementById('payment_success').style.display = 'block';
																				document.getElementById('payment_cancelled').style.display = 'none';
																				document.getElementById('payment_failed').style.display = 'none';
																				// verifyPayment(response);
																},
																"prefill": {
																				"name": "{{ $order->name }}",
																				"email": "{{ $order->email }}",
																				"contact": "+91{{ $order->phone }}"
																},
																"notes": {
																				"address": "Razorpay Corporate Office"
																},
																"theme": {
																				"color": "#fff"
																},
																"modal": {
																				"ondismiss": function() {
																								document.getElementById('payment_cancelled').style.display = 'block';
																								document.getElementById('payment_failed').style.display = 'none';
																								document.getElementById('payment_success').style.display = 'none';
																				}
																}
												};

												var rzp1 = new Razorpay(options);
												rzp1.on('payment.failed', function(response) {
																// console.log(response);
																document.getElementById('payment_failed').style.display = 'block';
																document.getElementById('payment_cancelled').style.display = 'none';
																document.getElementById('payment_success').style.display = 'none';
												});
												rzp1.open();

								}

								window.onload = setPrice;

								const verifyPayment = async (data) => {
												try {
																const response = await axios.post('{{ route("verify_razorpay_payment", $order->id) }}', data)
																window.location.replace('{{ route("payment_success") }}');
																// window.location.replace(
																// 																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																'{{ config("app.main_url") . "/account/orders/" . $order->id . "?order_placed=true" }}');
												} catch (error) {
																console.log(error);
																if (error?.response?.data?.errors?.razorpay_order_id) {
																				errorToast(error?.response?.data?.errors?.razorpay_order_id[0])
																}
																if (error?.response?.data?.errors?.razorpay_payment_id) {
																				errorToast(error?.response?.data?.errors?.razorpay_payment_id[0])
																}
																if (error?.response?.data?.errors?.razorpay_signature) {
																				errorToast(error?.response?.data?.errors?.razorpay_signature[0])
																}
																if (error?.response?.data?.message) {
																				errorToast(error?.response?.data?.message)
																}
												} finally {
																return false;
												}
								}
				</script>

</html>
