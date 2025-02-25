@extends('administrator.layouts.application')

<style>
    .lightbox {
        height: 100px;
        width: 200px;
        float: left;
        margin: 10px;
    }



    .img-popup {

        position: fixed;

        top: 0;

        bottom: 0;

        left: 0;

        right: 0;

        background: transparent;

        text-align: center;

        display: none;

        z-index: 9999999999999;

        animation: pop-in;

        animation-duration: 0.5s;

        -webkit-animation: pop-in 0.5s;

        -moz-animation: pop-in 0.5s;

        -ms-animation: pop-in 0.5s;



    }



    .img-popup img {

        position: absolute;

        top: 50%;

        max-width: 80%;

        max-height: 80vh;

        display: inline-block;

        transform: translate(-50%, -50%);

    }



    .close-lightbox {

        position: absolute;

        top: 45px;

        right: 20%;

        padding: 0px 10px;

        color: #fff;

        font-size: 35px;

        border: 2px solid #fff;

        border-radius: 50%;

        z-index: 99;

        cursor: pointer;

    }

    .lightboxfadeout {

        animation: fadeout;

        animation-duration: 0.5s;

        -webkit-animation: fadeout 0.5s;

        -moz-animation: fadeout 0.5s;

        -ms-animation: fadeout 0.5s;

    }



    @keyframes pop-in {

        0% {

            opacity: 0;

            transform: scale(0.1);

        }

        100% {

            opacity: 1;

            transform: scale(1);

        }

    }



    @-webkit-keyframes pop-in {

        0% {

            opacity: 0;

            -webkit-transform: scale(0.1);

        }

        100% {

            opacity: 1;

            -webkit-transform: scale(1);

        }

    }



    @-moz-keyframes pop-in {

        0% {

            opacity: 0;

            -moz-transform: scale(0.1);

        }

        100% {

            opacity: 1;

            -moz-transform: scale(1);

        }

    }





    @keyframes fadeout {

        100% {

            opacity: 0;

            transform: scale(0.1);

        }

        0% {

            opacity: 1;

            transform: scale(1);

        }

    }



    @-webkit-keyframes fadeout {

        100% {

            opacity: 0;

            -webkit-transform: scale(0.1);

        }

        0% {

            opacity: 1;

            -webkit-transform: scale(1);

        }

    }



    @-moz-keyframes fadeout {

        100% {

            opacity: 0;

            -moz-transform: scale(0.1);

        }

        0% {

            opacity: 1;

            -moz-transform: scale(1);

        }

    }





    #dataTable_filter {

        float: right;

    }



    .form-control-sm {

        min-height: calc(1.6em + 0.5rem + 2px);

        padding: 0.25rem 0.5rem;

        font-size: 0.7875rem;

        border-radius: 0.2rem;

        float: right;

        width: 240px !important;

        margin-left: 6px;

    }



    .modal-footer {

        display: flex;

        flex-wrap: wrap;

        flex-shrink: 0;

        align-items: center;

        justify-content: space-evenly !important;

        padding: 0.75rem;

        border-top: 1px solid #dee2e6;

        border-bottom-right-radius: calc(0.3rem - 1px);

        border-bottom-left-radius: calc(0.3rem - 1px);

    }
</style>

@section('content')

<div class="">

    <div class="row mb-3">

        <div class="col-md-9">
        </div>

        <div class="col-md-3">

            <form method="get" action="{{ route('admin.payment.approved_bybatch') }}">

                <div class="input-group">

                    <select class="form-select" id="inputGroupSelect04" name="package" aria-label="Example select with button addon">

                        <option selected>Choose...</option>

                        <option value="1">Batch 4 Package 1</option>

                        <option value="2">Batch 5 Package 1</option>

                        <option value="5">Batch 6 Package 1</option>
                    </select>

                    <button class="btn btn-outline-secondary" type="submit">Filter</button>

                </div>

            </form>

        </div>

    </div>



    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">

                <div class="card-header">{{ __('Payment Approved Investors List') }} </div>
                @if (\Session::has('success'))
                <div class="alert alert-success">
                    {!! \Session::get('success') !!}
                </div>
                @endif

                <div class="card-body">
                    <table id="dataTable" class="table table-striped table-bordered table-hover table-responsive">
                        <thead class="thead-dark" style="background:#222;color:#fff">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Investor Name</th>

                                <th scope="col">Phone</th>

                                <th scope="col">Email</th>

                                <th scope="col">Package Name</th>

                                <th scope="col">Package Value</th>

                                <th scope="col">Booking Quantity</th>

                                <th scope="col">Total Payment</th>

                                <th scope="col">Payment Document</th>

                                <th scope="col">Payment Date</th>

                                <th scope="col">Status</th>

                                <th scope="col">Note</th>

                                <th scope="col">Updated By</th>



                            </tr>

                        </thead>

                        <tbody>



                            @php

                            $totalValue = 0;

                            $totalInvest = 0;

                            $totalInvestor = 0;

                            @endphp



                            @foreach ($list as $data)



                            <tr>

                                <th scope="row">{{ $data->code }}</th>

                                <td><a href="javascript:void(0)" id="show-user" data-id="{{ $data->id }}" data-url="{{ route('admin.booking.modal_info', $data->id) }}" class="btn btn-info show-user">{{ $data->investor_name }}</a></td>

                                <td>{{ $data->phone }}</td>

                                <td>{{ $data->email }}</td>

                                <td>{{ $data->name }}</td>

                                <td>{{ $data->value }}</td>

                                <td>{{ $data->booking_quantity }}</td>

                                <td>{{ $data->value * $data->booking_quantity }}</td>

                                <td>
                                    @if($data->payment_document)
                                    @if(pathinfo($data->payment_document, PATHINFO_EXTENSION) == 'pdf')
                                    <a href="{{ url($data->payment_document) }}" target="_blank" class="btn btn-primary">View PDF</a>
                                    @else
                                    <img class="lightbox" src="{{ url($data->payment_document) }}" alt="">
                                    @endif
                                    @endif
                                </td>

                                <td>{{ $data->payment_date }}</td>

                                <td>{{ $data->status }}</td>

                                <td>{{ $data->note }}</td>

                                <td>{{ $data->updated_by }}</td>

                            </tr>



                            @php

                            $totalInvest = $data->booking_quantity + $totalInvest;

                            $totalInvestor = $totalInvestor + 1;

                            @endphp



                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>



@if(Auth::guard('administrator')->user()->email == 'ahkafy@gmail.com' || Auth::guard('administrator')->user()->email == 'kafy@freshie.farm')

<h2>Total Invest = {{ $totalInvest * 50000 }}</h2>

<h2>Total Package Sold = {{ $totalInvest }}</h2>

<h2>Total Investor = {{ $totalInvestor }}</h2>

@endif



<!-- Modal -->



<div class="modal fade" id="userShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="#userShowModal">Investment Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Investor Profile</div>
                            <div class="card-body">
                                <p><strong>User ID:</strong> <span id="user-id"></span></p>
                                <p><strong>Name:</strong> <span id="user-name"></span></p>
                                <p><strong>Email:</strong> <span id="user-email"></span></p>
                                <p><strong>Phone:</strong> <span id="user-phone"></span></p>
                                <p><strong>Address:</strong> <span id="user-address"></span></p>
                                <p><strong>NID:</strong> <span id="user_nid"></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Investment History</div>
                            <div class="card-body">
                                <p><strong>No of Approved Entries:</strong> <span id="approved_entries"></span></p>
                                <p><strong>Total Approved Amount:</strong> <span id="approved_amount"></span></p>
                                <p><strong>Total Pending Entries:</strong> <span id="pending_entries"></span></p>
                                <p><strong>Total Pending Amount:</strong> <span id="pending_amount"></span></p>
                                <p><strong>Total Rejected Entries:</strong> <span id="rejected_entries"></span></p>
                                <p><strong>Total Rejected Amount:</strong> <span id="rejected_amount"></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-header">Current Investment Request</div>
                            <div class="card-body text-white">
                                <p><strong>Booking Code:</strong> <span id="booking_code"></span></p>
                                <p><strong>Package:</strong> <span id="package_name"></span></p>
                                <p><strong>Unit Priece:</strong> <span id="package_value"></span></p>
                                <p><strong>Booking Quantity:</strong> <span id="booking_quantity"></span></p>
                                <p><strong>Payable Invest:</strong> <span id="invest_value"></span></p>
                                <p><strong>Payment Method:</strong> <span id="payment_method"></span></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-start" data-bs-dismiss="modal">Close</button>
            </div>
        </div>

    </div>

</div>



















<script type="text/javascript">
    $(document).ready(function() {



        /* When click show user information */

        $('body').on('click', '#show-user', function() {

            var userURL = $(this).data('url');

            $.get(userURL, function(data) {

                $('#userShowModal').modal('show');

                $('.modal-backdrop').remove();

                $('#user-id').text(data[0].user_id);

                $('#user-name').text(data[0].user_name);

                $('#user-email').text(data[0].user_email);

                $('#user-phone').text(data[0].user_phone);

                $('#user-address').text(data[0].user_present_address);

                $('#user_nid').text(data[0].user_nid);

                $('#user_father_name').text(data[0].user_father_name);

                $('#user_nominee_name').text(data[0].user_nominee_name);

                $('#user_nominee_name').text(data[0].user_nominee_relation);







                console.log(data);

                console.log(data.length);



                var invest_value = 0;

                var number_of_approved_entries = 0

                var approved_amount = 0;

                var number_of_pending_entries = 0;

                var pending_amount = 0;

                var number_of_rejected_entries = 0;

                var rejected_amount = 0;





                for (var x = 0; x < data.length; x++) {



                    if (data[x].booking_status == "approved") {

                        approved_amount = approved_amount + data[x].package_value * data[x].booking_quantity;

                        number_of_approved_entries = number_of_approved_entries + 1;

                    }



                    $('#approved_entries').text(number_of_approved_entries);

                    $('#approved_amount').text(approved_amount);







                    if (data[x].booking_status == "pending" || data[x].booking_status == "") {

                        pending_amount = pending_amount + data[x].package_value * data[x].booking_quantity;

                        number_of_pending_entries = number_of_pending_entries + 1;

                    }



                    $('#pending_entries').text(number_of_pending_entries);

                    $('#pending_amount').text(pending_amount);





                    if (data[x].booking_status == "rejected") {

                        rejected_amount = rejected_amount + data[x].package_value * data[x].booking_quantity;

                        number_of_rejected_entries = number_of_rejected_entries + 1;

                    }



                    $('#rejected_entries').text(number_of_rejected_entries);

                    $('#rejected_amount').text(rejected_amount);





                    if (data[x].booking_status == "pending_approval") {

                        $('#package_name').text(data[x].package_name);

                        $('#package_value').text(data[x].package_value);

                        $('#booking_quantity').text(data[x].booking_quantity);

                        invest_value = data[x].booking_quantity * data[x].package_value;

                        $('#invest_value').text(invest_value);

                        $('#payment_method').text(data[x].payment_method);

                        $('#booking_code').text(data[x].booking_code);

                        $('#booking_id_form').attr('value', data[x].booking_id);

                        $('#user_id_form').attr('value', data[x].user_id);



                        var approve_link = 'https://pre.freshie.farm/administrator/payment/approve/' + data[x].booking_id;

                        $('#approve-link').attr('href', approve_link);



                        var reject_link = 'https://pre.freshie.farm/administrator/payment/reject/' + data[x].booking_id;

                        $('#reject-link').attr('href', reject_link);

                    }







                }







            })

        });



    });
</script>









<script>
    $(document).ready(function() {
        "use strict";

        $(".lightbox").click(function() {
            console.log('clicked img');
            var imgsrc = $(this).attr('src');
            $("body").append("<div class='img-popup'><span class='close-lightbox'>&times;</span><img src='" + imgsrc + "'></div>");
            $(".close-lightbox, .img-popup").click(function() {
                $(".img-popup").fadeOut(500, function() {

                    $(this).remove();
                }).addClass("lightboxfadeout");
            });
        });

        $(".lightbox").click(function() {
            $(".img-popup").fadeIn(500);
        });

        $(".close-lightbox").click(function() {
            $(".img-popup").fadeOut(500);
        });

    });
</script>



<script>
    const date = new Date();



    let day = date.getDate();

    let month = date.getMonth() + 1;

    let year = date.getFullYear();



    let currentDate = `${day}-${month}-${year}`;







    new DataTable('#dataTable', {

        dom: 'Bfrtip',

        buttons: [

            {

                extend: 'excelHtml5',

                title: 'Freshie_' + currentDate,

                footer: true

            },

        ],



        "pageLength": 20,

    });
</script>

@endsection