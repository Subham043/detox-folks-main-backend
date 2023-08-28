@extends('admin.layouts.dashboard')



@section('content')

<div class="page-content">
    <div class="container-fluid">

        @include('admin.includes.breadcrumb', ['page'=>'Order', 'page_link'=>route('order_admin.paginate.get'), 'list'=>['Detail']])

        <div class="row project-wrapper">
            <div class="col-xxl-12">

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title flex-grow-1 mb-0">Order #{{$order->id}}</h5>
                                    {{-- <div class="flex-shrink-0">
                                        <a href="apps-invoices-details.html" class="btn btn-secondary btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> Invoice</a>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-nowrap align-middle table-borderless mb-0">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th scope="col">Product Details</th>
                                                <th scope="col">Item Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col" class="text-end">Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->products as $k => $v)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-wrap align-items-center">
                                                        <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                            <img src="{{$v->image_link}}" alt="" class="img-fluid d-block">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="fs-16"><a href="#" class="link-primary">{{$v->name}}</a></h5>
                                                            <p class="text-muted mb-0"><span class="fw-medium">{{$v->short_description}}</span></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>&#8377; {{$v->discount_in_price}}/pieces</td>
                                                <td>{{$v->quantity}}</td>
                                                <td class="fw-medium text-end">
                                                    &#8377; {{$v->amount}}
                                                </td>
                                            </tr>
                                            @endforeach

                                            <tr class="border-top border-top-dashed">
                                                <th>
                                                    Sub-Total :
                                                </th>
                                                <td></td>
                                                <th class="text-end" colspan="4">&#8377; {{$order->subtotal}}</th>
                                            </tr>
                                            @foreach($order->charges as $k=>$v)
                                            <tr class="border-top border-top-dashed">
                                                <th>
                                                    {{$v->charges_name}} :
                                                </th>
                                                <td></td>
                                                <th class="text-end" colspan="4">&#8377; {{$v->charges_in_amount}}</th>
                                            </tr>
                                            @endforeach
                                            <tr class="border-top border-top-dashed">
                                                <th>
                                                    Tax :
                                                </th>
                                                <td></td>
                                                <th class="text-end" colspan="4">&#8377; {{$order->total_tax}}</th>
                                            </tr>
                                            <tr class="border-top border-top-dashed">
                                                <th>
                                                    Discount :
                                                </th>
                                                <td></td>
                                                <th class="text-end" colspan="4">&#8377; {{$order->discount_price}}</th>
                                            </tr>
                                            <tr class="border-top border-top-dashed">
                                                <th>
                                                    Total :
                                                </th>
                                                <td></td>
                                                <th class="text-end" colspan="4">&#8377; {{$order->total_price}}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                        <div class="card">
                            <div class="card-header">
                                <div class="d-sm-flex align-items-center">
                                    <h5 class="card-title flex-grow-1 mb-0">Order Status</h5>
                                    @if(!in_array(\App\Enums\OrderEnumStatus::CANCELLED, $order_statuses))
                                    <div class="flex-shrink-0 mt-2 mt-sm-0 row gap-1">
                                            @if(!in_array(\App\Enums\OrderEnumStatus::CONFIRMED, $order_statuses))
                                                <button data-link="{{route('order_admin.update_order_status.get', $order->id)}}" class="btn btn-soft-success btn-sm mt-2 mt-sm-0 remove-item-btn col-auto"><i class="ri-donut-chart-line align-bottom me-1"></i>
                                                    Change Order Status :
                                                    CONFIRMED
                                                </button>
                                            @elseif(!in_array(\App\Enums\OrderEnumStatus::OFD, $order_statuses))
                                                <button data-link="{{route('order_admin.update_order_status.get', $order->id)}}" class="btn btn-soft-success btn-sm mt-2 mt-sm-0 remove-item-btn col-auto"><i class="ri-donut-chart-line align-bottom me-1"></i>
                                                    Change Order Status :
                                                    OUT FOR DELIVERY
                                                </button>
                                            @elseif(!in_array(\App\Enums\OrderEnumStatus::DELIVERED, $order_statuses))
                                                <button data-link="{{route('order_admin.update_order_status.get', $order->id)}}" class="btn btn-soft-success btn-sm mt-2 mt-sm-0 remove-item-btn col-auto"><i class="ri-donut-chart-line align-bottom me-1"></i>
                                                    Change Order Status :
                                                    DELIVERED
                                                </button>
                                            @endif
                                        <button data-link="{{route('order_admin.cancel.get', $order->id)}}" class="btn btn-soft-danger btn-sm mt-2 mt-sm-0 remove-item-btn col-auto"><i class="mdi mdi-archive-remove-outline align-bottom me-1"></i> Cancel
                                            Order</button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="profile-timeline">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="headingOne">
                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 avatar-xs">
                                                            <div
                                                                @class([
                                                                    'avatar-title rounded-circle',
                                                                    'bg-success'=>(in_array(\App\Enums\OrderEnumStatus::PROCESSING, $order_statuses)),
                                                                    'bg-light text-success'=>!(in_array(\App\Enums\OrderEnumStatus::PROCESSING, $order_statuses))
                                                                ])>
                                                                <i class="ri-shopping-bag-line"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-15 mb-0 fw-semibold">PROCESSING @if((in_array(\App\Enums\OrderEnumStatus::PROCESSING, $order_statuses)))- @foreach($order->statuses as $v) @if(\App\Enums\OrderEnumStatus::PROCESSING==$v->status)<span class="fw-normal">{{$order->created_at->diffForHumans()}}</span>@endif @endforeach @endif</h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        @if(!in_array(\App\Enums\OrderEnumStatus::CANCELLED, $order_statuses))
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="headingTwo">
                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 avatar-xs">
                                                            <div
                                                                @class([
                                                                    'avatar-title rounded-circle',
                                                                    'bg-success'=>(in_array(\App\Enums\OrderEnumStatus::CONFIRMED, $order_statuses)),
                                                                    'bg-light text-success'=>!(in_array(\App\Enums\OrderEnumStatus::CONFIRMED, $order_statuses))
                                                                ])>
                                                                <i class="mdi mdi-gift-outline"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-15 mb-1 fw-semibold">CONFIRMED @if((in_array(\App\Enums\OrderEnumStatus::CONFIRMED, $order_statuses)))- @foreach($order->statuses as $v) @if(\App\Enums\OrderEnumStatus::CONFIRMED==$v->status)<span class="fw-normal">{{$order->created_at->diffForHumans()}}</span>@endif @endforeach @endif</h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="headingThree">
                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 avatar-xs">
                                                            <div @class([
                                                                'avatar-title rounded-circle',
                                                                'bg-success'=>(in_array(\App\Enums\OrderEnumStatus::OFD, $order_statuses)),
                                                                'bg-light text-success'=>!(in_array(\App\Enums\OrderEnumStatus::OFD, $order_statuses))
                                                            ])>
                                                                <i class="ri-truck-line"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-15 mb-1 fw-semibold">OUT FOR DELIVERY @if((in_array(\App\Enums\OrderEnumStatus::OFD, $order_statuses)))- @foreach($order->statuses as $v) @if(\App\Enums\OrderEnumStatus::OFD==$v->status)<span class="fw-normal">{{$order->created_at->diffForHumans()}}</span>@endif @endforeach @endif</h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="headingFive">
                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFile" aria-expanded="false">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 avatar-xs">
                                                            <div @class([
                                                                'avatar-title rounded-circle',
                                                                'bg-success'=>(in_array(\App\Enums\OrderEnumStatus::DELIVERED, $order_statuses)),
                                                                'bg-light text-success'=>!(in_array(\App\Enums\OrderEnumStatus::DELIVERED, $order_statuses))
                                                            ])>
                                                                <i class="mdi mdi-package-variant"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-14 mb-0 fw-semibold">DELIVERED @if((in_array(\App\Enums\OrderEnumStatus::DELIVERED, $order_statuses)))- @foreach($order->statuses as $v) @if(\App\Enums\OrderEnumStatus::DELIVERED==$v->status)<span class="fw-normal">{{$order->created_at->diffForHumans()}}</span>@endif @endforeach @endif</h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        @else
                                        <div class="accordion-item border-0">
                                            <div class="accordion-header" id="headingTwo">
                                                <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 avatar-xs">
                                                            <div
                                                                @class([
                                                                    'avatar-title rounded-circle',
                                                                    'bg-danger',
                                                                ])>
                                                                <i class="ri-close-line"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="fs-15 mb-1 fw-semibold">CANCELLED @if(!(in_array(\App\Enums\OrderEnumStatus::CANCELLED, $order_statuses)))- @foreach($order->statuses as $v) @if(\App\Enums\OrderEnumStatus::DELIVERED==$v->status)<span class="fw-normal">{{$order->created_at->diffForHumans()}}</span>@endif @endforeach @endif</h6>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <!--end accordion-->
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                    <div class="col-xl-4">

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex">
                                    <h5 class="card-title flex-grow-1 mb-0">Customer Details</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0 vstack gap-3">
                                    <li><i class="ri-user-2-line me-2 align-middle text-muted fs-16"></i>{{$order->name}}
                                    </li>
                                    <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{$order->email}}
                                    </li>
                                    <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>+91-{{$order->phone}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">

                        <!--end card-->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Shipping Address
                                </h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled vstack gap-2 mb-0">
                                    <li>{{$order->address}}</li>
                                    <li>{{$order->city}} - {{$order->pin}}</li>
                                    <li>{{$order->state}}</li>
                                    <li>{{$order->country}}</li>
                                </ul>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <div class="col-xl-4">

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> Payment
                                        Details</h5>
                                    @if(!in_array(\App\Enums\OrderEnumStatus::CANCELLED, $order_statuses))
                                        @if($order->payment->status != \App\Enums\PaymentStatus::PAID)
                                            <div class="flex-shrink-0 mt-2 mt-sm-0 row gap-1">
                                                <button data-link="{{route('order_admin.payment_update.get', $order->id)}}" class="btn btn-soft-success btn-sm mt-2 mt-sm-0 remove-item-btn col-auto">
                                                    Change Payment Status :
                                                    PAID
                                                </button>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="flex-shrink-0">
                                        <p class="text-muted mb-0">Payment Method:</p>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">{{$order->payment->mode}}</h6>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="flex-shrink-0">
                                        <p class="text-muted mb-0">Payment Status:</p>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">{{$order->payment->status}}</h6>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <p class="text-muted mb-0">Total Amount:</p>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">&#8377; {{$order->total_price}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                </div>

            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div><!-- End Page-content -->

@stop
