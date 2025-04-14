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
                                @vite(['resources/admin/css/main.css'])

								<style>
                                    body,
                                    .form-body,
                                    .form-content {
                                                    background-color: #eee;
                                    }
								</style>
                                <script src="{{asset('payment/qr.min.js')}}"></script>
                                <script src="{{ asset('admin/js/pages/iziToast.min.js') }}"></script>
                                <script src="{{ asset('admin/js/pages/axios.min.js') }}"></script>

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
																												<h5 class="mb-3">Please scan the code and make the payment.</h5>
																												{{-- <div class="hstack justify-content-center gap-2">
																																<div class="spinner-border text-dark" role="status"></div>
																												</div> --}}
																												<div class="hstack justify-content-center gap-2">
                                                                                                                    <img id="qrcode-img" />
                                                                                                                </div>
                                                                                                                <div class="text-center mt-3">
                                                                                                                    <button class="btn btn-dark" id="submitBtn">Check Payment Status</button>
                                                                                                                </div>
																								</div>
																				</div>

																</div>

												</div>
								</div>
				</body>
				<script type="text/javascript" nonce="{{ csp_nonce() }}">
                    const upiString = "{!!$upi!!}";
                    const encodedUpi = encodeURI(upiString);

                    QRCode.toDataURL(encodedUpi, { errorCorrectionLevel: 'H' }, function (err, url) {
                        if (err) {
                        console.error(err);
                        } else {
                        document.getElementById('qrcode-img').src = url;
                        }
                    });

                    const errorToast = (message) =>{
                        iziToast.error({
                            title: 'Error',
                            message: message,
                            position: 'bottomCenter',
                            timeout:7000
                        });
                    }
                    const successToast = (message) =>{
                        iziToast.success({
                            title: 'Success',
                            message: message,
                            position: 'bottomCenter',
                            timeout:6000
                        });
                    }

                    const spinner = `
                        <span class="d-flex align-items-center">
                            <span class="spinner-border flex-shrink-0" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                            <span class="flex-grow-1 ms-2">
                                Loading...
                            </span>
                        </span>
                    `;

                    document.querySelectorAll('#submitBtn').forEach(el => {
                        el.addEventListener('click', function() {
                            verifyPayment()
                        })
                    });

                    const verifyPayment = async () => {
                        var submitBtn = document.getElementById('submitBtn')
                        submitBtn.innerHTML = spinner
                        submitBtn.disabled = true;
                        try {
                            const response = await axios.get("{{route('delivery_management.agent.order_generate_qr_code_verify.get', $order_id)}}");
                            if(response.data.data.payment.status==='PAID'){
                                successToast('Payment completed successfully.');
                                window.location.href = "{{route('delivery_management.agent.order_detail.get', $order_id)}}";
                            }else{
                                errorToast('Payment Pending');
                            }
                        } catch (error) {
                            errorToast('Something went wrong. Please try again.');
                        } finally {
                            submitBtn.innerHTML = `Check Payment Status`
                            submitBtn.disabled = false;
                        }
                    }
				</script>

</html>
