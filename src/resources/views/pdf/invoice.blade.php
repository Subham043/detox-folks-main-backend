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
																margin-bottom: 30px;
												}

												#logo {
																text-align: center;
																margin-bottom: 10px;
												}

												#logo img {
																width: 90px;
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
																text-align: right;
																width: 52px;
																margin-right: 10px;
																display: inline-block;
																font-size: 0.8em;
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

												table tr:nth-child(2n-1) td {
																background: #F5F5F5;
												}

												table th,
												table td {
																text-align: center;
												}

												table th {
																padding: 5px 20px;
																color: #5D6975;
																border-bottom: 1px solid #C1CED9;
																white-space: nowrap;
																font-weight: normal;
												}

												.charge_total,
												.charge_name {
																border-bottom: 1px solid #C1CED9;
																font-size: 1.2em;
																background: #FFF !important;
																padding: 10px 20px;
												}

												.charge_row_first td {
																border-top: 1px solid #C1CED9;
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

												#notices .notice {
																color: #5D6975;
																font-size: 1.2em;
												}

												footer {
																color: #5D6975;
																width: 100%;
																height: 30px;
																position: absolute;
																bottom: 0;
																border-top: 1px solid #C1CED9;
																padding: 8px 0;
																text-align: center;
												}

												.badge {
																padding: 5px 10px;
																border-radius: 10px;
																margin-bottom: 10px;
																color: white;
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
								</style>
				</head>

				<body>
								<header class="clearfix">
												<div id="logo">
																<img src="{{ public_path("admin/pdf/logo.webp") }}">
												</div>
												<h1>ORDER#{{ $order->id }}</h1>
												@if ($order->payment)
																<div id="company">
																				<div class="badge badge-{{ $order->payment->status }}">{{ $order->payment->status }}</div>
																</div>
																<div class="clearfix"></div>
												@endif
												<div id="company" class="clearfix">
																<div>Parcelcounter</div>
																<div>2, OVH ROAD, BASAVANAGUDI, <br />BENGALURU, Pin - 560004</div>
																<div>9380911495</div>
																<div><a href="mailto:detoxfolks@gmail.com">detoxfolks@gmail.com</a></div>
												</div>
												<div id="project">
																<div><span>CLIENT</span> {{ $order->name }}</div>
																<div><span>PHONE</span> +91-{{ $order->phone }}</div>
																<div><span>EMAIL</span> <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></div>
																<div><span>ADDRESS</span> {{ $order->address }}, {{ $order->city }} - {{ $order->pin }},
																				{{ $order->state }}, {{ $order->country }}</div>
																<div><span>DATE</span> {{ $order->created_at->format("M d, Y") }}</div>
																<div><span>METHOD</span> {{ $order->payment ? $order->payment->mode : "" }}</div>
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
																								<td class="charge_name" colspan="4">Subtotal</td>
																								<td class="charge_total">Rs. {{ $order->subtotal }}</td>
																				</tr>
																				@foreach ($order->charges as $k => $v)
																								<tr>
																												<td class="charge_name" colspan="4">{{ $v->charges_name }}</td>
																												<td class="charge_total">Rs. {{ $v->total_charge_in_amount }}</td>
																								</tr>
																				@endforeach
																				<tr>
																								<td class="charge_name" colspan="4">Total</td>
																								<td class="charge_total">Rs. {{ $order->total_price }}</td>
																				</tr>
																</tbody>
												</table>
												<div id="notices">
																<div>NOTICE:</div>
																<div class="notice">Prices are inclusive of GST.</div>
												</div>
								</main>
								<footer>
												Invoice was created on a computer and is valid without the signature and seal.
								</footer>
				</body>

</html>
