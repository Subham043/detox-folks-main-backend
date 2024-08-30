<!DOCTYPE html>
<html lang="en">

				<head>
								<meta charset="utf-8">
								<title>Parcelcounter - ORDER#{{ $order->id }}</title>
								<style nonce="{{ csp_nonce() }}">
												.clearfix:after {
																content: "";
																display: table;
																clear: both;
												}

												a {
																color: #5D6975;
																text-decoration: underline;
												}

												body {
																position: relative;
																width: 100%;
																height: 100%;
																margin: 0 auto;
																color: #001028;
																background: #FFFFFF;
																font-family: Arial, sans-serif;
																font-size: 12px;
																font-family: Arial;
												}

												header {
																padding: 10px 0;
																margin-bottom: 15px;
												}

                                                .logo-header{
                                                    margin-bottom: 0px;
                                                    padding-bottom: 0;
                                                }

												#logo {
																text-align: center;
																margin-bottom: 0px;
												}

												#logo img {
																width: 120px;
												}

												h1 {
																border-top: 1px solid #5D6975;
																border-bottom: 1px solid #5D6975;
																color: #5D6975;
																font-size: 2.4em;
																line-height: 1.4em;
																font-weight: normal;
																text-align: center;
																margin: 0 0 20px 0;
																background: url({{ public_path("admin/pdf/dimension.png") }});
												}

												#project {
																float: left;
												}

												#project span {
																color: #5D6975;
																text-align: left;
																width: auto;
																margin-right: 10px;
																display: inline;
																font-size: 1.1em;
												}

                                                #project .project-left-div{
                                                    margin-bottom: 5px;

                                                }

                                                #project .project-left-div p{
                                                    font-size: 1.2em;
                                                    margin: 0;
                                                    padding: 0;

                                                }

												#company {
																float: right;
																text-align: right;
												}

												#project div,
												#company div {
																white-space: nowrap;
												}

												table {
																width: 100%;
																border-collapse: collapse;
																border-spacing: 0;
																margin-bottom: 20px;
												}

												table thead tr th {
												/* table tr:nth-child(2n-1) td { */
																background: #F5F5F5;
                                                                padding: 15px 20px;
												}

												table th,
												table td {
																text-align: center;
												}

												table th {
																padding: 5px 20px;
																color: #5D6975;
																border-top: 1px solid #222;
																border-bottom: 1px solid #222;
																/* border-top: 1px solid #C1CED9;
																border-bottom: 1px solid #C1CED9; */
																white-space: nowrap;
																font-weight: normal;
												}

												.charge_total,
												.charge_name {
																font-size: 1.2em;
																background: #FFF !important;
																padding: 10px 20px;
												}
												.charge_name {
																padding: 10px 3px;
												}

                                                .charge_row_last .charge_total,
												.charge_row_last .charge_name {
                                                    border-top: 1px solid #222;
												}

                                                .payment_method{
                                                    padding: 10px 3px;
                                                    text-align: left;
                                                    font-size: 1.3em;
                                                }

                                                .payment_method span{
                                                    font-style: italic;
                                                    font-weight: bold;
                                                }

												.charge_row_first td {
																border-top: 1px solid #222;
												}

												.charge_name {
																color: #5D6975;
																text-align: left
												}

												.charge_total {
																text-align: right
												}

												table .service,
												table .desc {
																text-align: left;
												}

												table td {
																padding: 15px 20px;
																text-align: center;
												}

												table td.service,
												table td.desc {
																vertical-align: top;
												}

												table td.unit,
												table td.qty,
												table td.total {
																font-size: 1.2em;
												}

												table td.total {
																text-align: right
												}

												table td.grand {
																border-top: 1px solid #5D6975;
																;
												}

												#notices {
                                                    margin-bottom: 30px;
                                                }
												#notices .notice {
																color: #5D6975;
																font-size: 1.4em;
												}

                                                #contact_us .thank_you{
                                                    font-size: 1.8em;
                                                    font-weight: bold;
                                                    margin-bottom: 20px;
                                                }

                                                #contact_us .contact{
                                                    font-size: 1.6em;
                                                    font-weight: bold;
                                                    margin-bottom: 10px;
                                                }

                                                #contact_us .address_div div{
                                                    font-size: 1.3em;
                                                    color: #5D6975;
                                                }

												footer {
																color: #5D6975;
																width: 100%;
																height: 30px;
																position: absolute;
																bottom: 0;
																border-top: 2px solid #222;
																padding: 8px 0;
																text-align: center;
												}

												.badge {
																padding: 5px 10px;
																border-radius: 10px;
																margin-top: 10px;
																color: white;
                                                                display: inline-block;
                                                                width: auto;
												}

												.badge-PAID {
																background: green;
												}

												.badge-REFUND {
																background: rgb(172, 6, 6);
												}

												.badge-PENDING {
																background: rgba(15, 137, 203, 0.846);
												}

												.text-right {
																text-align: right
												}

                                                .border-bottom-bold{
                                                    border-bottom: 2px solid #222;
                                                    margin-bottom: 10px;
                                                }
                                                .logo-header-heading{
                                                    font-size: 3.5em;
                                                    font-weight: 700;
                                                }
                                                .invoice_to_text{
                                                    font-size: 1.3em !important;
                                                    color: #5D6975;
                                                }
                                                .invoice_to_name_text{
                                                    font-size: 2em !important;
                                                    font-weight: bold;
                                                    color: #222;
                                                    margin-top: 10px;
                                                    margin-bottom: 5px;
                                                }
								</style>
				</head>

				<body>
								<header class="logo-header clearfix">
                                        <div>
                                            <div id="company" class="clearfix">
                                                <div><span class="logo-header-heading">INVOICE</span></div>
                                            </div>
                                            <div id="project">
                                                <div id="logo">
                                                            <img src="{{ public_path("admin/pdf/logo.png") }}">
                                                </div>
                                            </div>
                                        </div>
								</header>
								<header class="clearfix">
                                            <div class="border-bottom-bold"></div>
												<div id="company" class="clearfix">
                                                    <div><span class="invoice_to_text">Invoice To : </span></div>
                                                    <div class="invoice_to_name_text">{{ $order->name }}</div>
                                                    <div>+91-{{ $order->phone }}</div>
                                                    <div><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></div>
                                                    <div>{{ $order->address }},<br/> {{ $order->city }} - {{ $order->pin }},<br/>
                                                        {{ $order->state }}, {{ $order->country }}</div>
                                                </div>
                                                <div id="project">
                                                    <div class="project-left-div"><p><span>INVOICE NO :</span> {{ $order->id }}</p></div>
                                                    <div class="project-left-div"><p><span>DATE :</span> {{ $order->created_at->format("M d, Y") }}</p></div>
                                                    @if ($order->payment)
                                                        <div class="badge badge-{{ $order->payment->status }}">{{ $order->payment->status }}</div>
                                                    @endif
												</div>
								</header>
								<main>
												<table>
																<thead>
																				<tr>
																								<th class="service">SL. NO.</th>
																								<th class="desc">NAME</th>
																								<th>PRICE</th>
																								<th>QTY</th>
																								<th class="text-right">TOTAL</th>
																				</tr>
																</thead>
																<tbody>
																				@foreach ($order->products as $k => $v)
																								<tr>
																												<td class="service">{{ $k + 1 }}</td>
																												<td class="desc">{{ $v->name }}</td>
																												<td class="unit">Rs. {{ $v->discount_in_price }}/pieces</td>
																												<td class="qty">{{ $v->quantity }}</td>
																												<td class="total">Rs. {{ $v->amount }}</td>
																								</tr>
																				@endforeach
																				<tr class="charge_row_first">
																								<td colspan="3" class="payment_method"><span>Payment Method</span> : {{ $order->payment ? $order->payment->mode : "" }}</td>
																								<td class="charge_name">Subtotal</td>
																								<td class="charge_total">Rs. {{ $order->subtotal }}</td>
																				</tr>
																				@foreach ($order->charges as $k => $v)
                                                                                                <tr>
                                                                                                                <td></td>
                                                                                                                <td></td>
                                                                                                                <td></td>
                                                                                                                <td class="charge_name">{{ $v->charges_name }}</td>
																												<td class="charge_total">Rs. {{ $v->total_charge_in_amount }}</td>
                                                                                                </tr>
																				@endforeach
																				<tr class="charge_row_last">
                                                                                                <td></td>
																								<td></td>
																								<td></td>
																								<td class="charge_name">Total</td>
																								<td class="charge_total">Rs. {{ $order->total_price }}</td>
																				</tr>
																</tbody>
												</table>
												<div id="notices">
																<div class="notice">( All Prices are inclusive of GST )</div>
												</div>
												<div id="contact_us">
																<div class="thank_you">Thank you for purchase!</div>
																<div class="contact">Contact Us</div>
                                                                <div class="address_div">
                                                                    <div>9389911492</div>
                                                                    <div><a href="mailto:crm.detoxfolks@gmail.com">crm.detoxfolks@gmail.com</a></div>
                                                                    <div>Detoxfolks Private Limited<br/>NO.2 OVH ROAD , BASAVANGUDI, <br />BANGALORE - 560004<br />GST NO : 29AAGCD8708B1ZO</div>
                                                                </div>
												</div>
								</main>
								<footer>
												Invoice was created on a computer and is valid without the signature and seal.
								</footer>
				</body>

</html>
