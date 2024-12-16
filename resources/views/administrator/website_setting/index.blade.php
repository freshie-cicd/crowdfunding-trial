@extends('administrator.layouts.application')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Website Settings</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <a href="{{ route('admin.website.settings.edit') }}" class="btn btn-primary mt-3">Edit Settings</a>
            </div>

            <div class="card shadow-lg">
                <div class="card-body">
                    <table class="table table-bordered">
                        @php
                            $fields = [
                                'Address' => $settings->address,
                                'Phone' => $settings->phone,
                                'Email' => $settings->email,
                                'Light Logo' => $settings->light_logo
                                    ? '<img src="' . asset('storage/' . $settings->light_logo) . '" width="100">'
                                    : 'Not Uploaded',
                                'Dark Logo' => $settings->dark_logo
                                    ? '<img src="' . asset('storage/' . $settings->dark_logo) . '" width="100">'
                                    : 'Not Uploaded',
                                'Favicon' => $settings->favicon
                                    ? '<img src="' . asset('storage/' . $settings->favicon) . '" width="50">'
                                    : 'Not Uploaded',
                                'Account Holder Name' => $settings->account_holder_name,
                                'Bank Name' => $settings->bank_name,
                                'Branch Name' => $settings->branch_name,
                                'Account Number' => $settings->account_number,
                                'IFSC Code' => $settings->ifsc_code,
                                'SWIFT Code' => $settings->swift_code,
                                'Account Type' => $settings->account_type,
                                'Currency' => $settings->currency,
                                'WhatsApp' => $settings->whatsapp,
                                'YouTube' => $settings->youtube,
                                'Facebook' => $settings->facebook,
                                'Twitter' => $settings->twitter,
                                'LinkedIn' => $settings->linkedin,
                            ];
                        @endphp

                        @foreach ($fields as $label => $value)
                            <tr>
                                <th>{{ $label }}</th>
                                <td>{!! $value ?? 'Not Set' !!}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
