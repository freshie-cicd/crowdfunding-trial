@extends('administrator.layouts.application')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4 text-center">Edit Website Settings</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>There were some issues with your input:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-lg">
            <div class="card-body">
                <form action="{{ route('admin.website.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        @php
                            $fields = [
                                ['label' => 'Address', 'name' => 'address', 'type' => 'text'],
                                ['label' => 'Phone', 'name' => 'phone', 'type' => 'text'],
                                ['label' => 'Email', 'name' => 'email', 'type' => 'email'],
                                ['label' => 'Light Logo', 'name' => 'light_logo', 'type' => 'file'],
                                ['label' => 'Dark Logo', 'name' => 'dark_logo', 'type' => 'file'],
                                ['label' => 'Favicon', 'name' => 'favicon', 'type' => 'file'],
                                ['label' => 'Account Holder Name', 'name' => 'account_holder_name', 'type' => 'text'],
                                ['label' => 'Bank Name', 'name' => 'bank_name', 'type' => 'text'],
                                ['label' => 'Branch Name', 'name' => 'branch_name', 'type' => 'text'],
                                ['label' => 'Account Number', 'name' => 'account_number', 'type' => 'text'],
                                ['label' => 'IFSC Code', 'name' => 'ifsc_code', 'type' => 'text'],
                                ['label' => 'SWIFT Code', 'name' => 'swift_code', 'type' => 'text'],
                                ['label' => 'Account Type', 'name' => 'account_type', 'type' => 'text'],
                                ['label' => 'Currency', 'name' => 'currency', 'type' => 'text'],
                                ['label' => 'WhatsApp', 'name' => 'whatsapp', 'type' => 'url'],
                                ['label' => 'YouTube', 'name' => 'youtube', 'type' => 'url'],
                                ['label' => 'Facebook', 'name' => 'facebook', 'type' => 'url'],
                                ['label' => 'Twitter', 'name' => 'twitter', 'type' => 'url'],
                                ['label' => 'LinkedIn', 'name' => 'linkedin', 'type' => 'url'],
                            ];
                        @endphp

                        @foreach ($fields as $field)
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}</label>
                                    @if ($field['type'] === 'file')
                                        <input type="file" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                            class="form-control border rounded" onchange="previewImage(event, '{{ $field['name'] }}')">
                                        <div id="preview-{{ $field['name'] }}" class="mt-2">
                                            @if ($settings->{$field['name']})
                                                <img src="{{ asset('storage/' . $settings->{$field['name']}) }}"
                                                    alt="{{ $field['label'] }}" class="img-thumbnail" width="120">
                                            @endif
                                        </div>
                                    @else
                                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                            id="{{ $field['name'] }}" value="{{ old($field['name'], $settings->{$field['name']}) }}"
                                            class="form-control border rounded">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event, fieldId) {
            const previewDiv = document.getElementById('preview-' + fieldId);
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewDiv.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" width="120" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            } else {
                previewDiv.innerHTML = '';
            }
        }
    </script>
@endsection
