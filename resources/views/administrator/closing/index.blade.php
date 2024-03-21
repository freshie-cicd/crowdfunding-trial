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
.lightboxfadeout{
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


#dataTable_filter{
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
        <div class="col-md-9"><h3>Cow Profiles</h3></div>
        <div class="col-md-3">
        <form method="get" action="{{ route('admin.borga.cow_profile') }}">
            <div class="input-group">
                  <select class="form-select" id="inputGroupSelect04" name="package" aria-label="Example select with button addon">
                    <option selected>Choose...</option>
                    <option value="1">Batch 4 Package 1</option>
                  </select>
                  <button class="btn btn-outline-secondary" type="submit">Filter</button>
            </div>
          </form>
        </div>
    </div>
    
    <div class="row justify-content-center">
            
            
        
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Cow Profiles') }}    <a href="{{ route('admin.borga.cow_profile_create') }}" class="float-end btn btn-sm btn-primary">Add new</a></div>

                @if (\Session::has('success'))
                    <div class="alert alert-success">
                            {!! \Session::get('success') !!}
                    </div>
                @endif
                
                

                <div class="card-body">

                    <table id="dataTable" class="table table-striped table-bordered table-hover table-responsive">
                      <thead class="thead-dark" style="background:#222;color:#fff">
                        <tr>
                            <th scope="col">SL</th>
                          <th scope="col">Booking Code</th>
                          <th scope="col">Batch</th>
                          <th scope="col">Total Investment (Package)</th>
                          <th scope="col">Withdrawal Amount (Package)</th>
                          <th scope="col">Reinvest Amount (Package)</th>
                          <th scope="col">Total Profit</th>
                          <th scope="col">Bank Details</th>
                          <th scope="col">Investor</th>
                          <th scope="col">Phone</th>
                          <th scope="col">Email</th>
                          <th scope="col">Note</th>
                          <th scope="col">#</th>
                          
                        </tr>
                      </thead>
                      <tbody>

                          
                      @foreach ($data as $d)

                        <tr>
                            <th scope="row">{{ $d->id }}</th>
                          <th scope="row">{{ $d->booking_code }}</th>
                          <th scope="row">{{ $d->package_name }}</th>
                          <th scope="row">{{ $d->package_value * $d->booking_quantity }} ({{ $d->booking_quantity }})</th>
                          <th scope="row">{{ $d->capital_withdrawal_amount }} ({{ $d->package_to_withdraw }})</th>
                          <th scope="row">{{ $d->after_withdrawal_amount }} ({{ $d->package_after_withdrawal }})</th>
                          <th scope="row">{{ $d->profit_withdrawal_amount }}</th>
                          <th scope="row">{{ $d->bank_name }}</th>
                          <th scope="row">{{ $d->user_name }}</th>
                          <th scope="row">{{ $d->user_phone }}</th>
                          <th scope="row">{{ $d->user_email }}</th>
                          <th scope="row">{{ $d->note ?? '' }}</th>
                          <th scope="row"><button class="btn btn-success btn-sm">Action</button></th>
     
                          
                        </tr>

             

                      @endforeach
                      </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</div>






<script>

$(document).ready(function () {
    "use strict";
    $(".lightbox").click(function () {
        var imgsrc = $(this).attr('src');
        $("body").append("<div class='img-popup'><span class='close-lightbox'>&times;</span><img src='" + imgsrc + "'></div>");
        $(".close-lightbox, .img-popup").click(function () {
            $(".img-popup").fadeOut(500, function () {
                $(this).remove();
            }).addClass("lightboxfadeout");
        });

    });
    $(".lightbox").click(function () {
        $(".img-popup").fadeIn(500);
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
                        title: 'Freshie_'+ currentDate,
                        footer: true
                      },
                     ],

              "pageLength": 20,
  });

</script>
@endsection
