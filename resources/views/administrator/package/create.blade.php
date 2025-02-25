@extends('administrator.layouts.application')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Add New Package') }}</div>
                    <div class="card-body">

                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                {!! \Session::get('success') !!}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('package.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for='project_id'
                                    class="col-md-4 col-form-label text-md-end">{{ __('Projects') }}</label>
                                <div class="col-md-4">
                                    <select id='project_id' type="text"
                                        class="form-control @error('project_id') is-invalid @enderror" name='project_id'
                                        value="{{ old('project_id') }}" required autocomplete='project_id' autofocus>
                                        <option value="">PLEASE SELECT</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Package Name') }}</label>
                                <div class="col-md-4">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for='description'
                                    class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>
                                <div class="col-md-4">
                                    <input id='description' type="text"
                                        class="form-control @error('description') is-invalid @enderror" name='description'
                                        value="{{ old('description') }}" required autocomplete='description' autofocus>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for='code'
                                    class="col-md-4 col-form-label text-md-end">{{ __('Code') }}</label>
                                <div class="col-md-4">
                                    <input id='code' type="text"
                                        class="form-control @error('code') is-invalid @enderror" name='code'
                                        value="{{ old('code') }}" required autocomplete='code' autofocus>

                                    @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for='value'
                                    class="col-md-4 col-form-label text-md-end">{{ __('Package Value') }}</label>
                                <div class="col-md-4">

                                    <input id='value' type="text"
                                        class="form-control @error('value') is-invalid @enderror" name='value'
                                        value="{{ old('value') }}" required autocomplete='value' autofocus>

                                    @error('value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for='capacity'
                                    class="col-md-4 col-form-label text-md-end">{{ __('Package Capacity') }}</label>

                                <div class="col-md-4">
                                    <input id='capacity' type="text"
                                        class="form-control @error('capacity') is-invalid @enderror" name='capacity'
                                        value="{{ old('capacity') }}" required autocomplete='capacity' autofocus>

                                    @error('capacity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for='fb_group_url'
                                    class="col-md-4 col-form-label text-md-end">{{ __('FB Group URL') }}</label>

                                <div class="col-md-4">
                                    <input id='fb_group_url' type="text"
                                        class="form-control @error('fb_group_url') is-invalid @enderror" name='fb_group_url'
                                        value="{{ old('fb_group_url') }}" required autocomplete='fb_group_url' autofocus>

                                    @error('fb_group_url')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for='status'
                                    class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>

                                <div class="col-md-4">
                                    <select id='status' type="text"
                                        class="form-control @error('status') is-invalid @enderror" name='status'
                                        value="{{ old('status') }}" required autocomplete='status' autofocus>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>

                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for='start_date'
                                    class="col-md-4 col-form-label text-md-end">{{ __('Start Date') }}</label>
                                <div class="col-md-4">
                                    <input id='start_date' type="date"
                                        class="form-control @error('start_date') is-invalid @enderror" name='start_date'
                                        value="{{ old('start_date') }}" required autocomplete='start_date' autofocus>
                                    @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for='end_date'
                                    class="col-md-4 col-form-label text-md-end">{{ __('End Date') }}</label>
                                <div class="col-md-4">
                                    <input id='end_date' type="date"
                                        class="form-control @error('end_date') is-invalid @enderror" name='end_date'
                                        value="{{ old('end_date') }}" required autocomplete='end_date' autofocus>
                                    @error('end_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">

                                <label for='note'
                                    class="col-md-4 col-form-label text-md-end">{{ __('Note') }}</label>
                                <div class="col-md-4">

                                    <input id='note' type="text"
                                        class="form-control @error('note') is-invalid @enderror" name='note'
                                        value="{{ old('note') }}" autocomplete='note' autofocus>

                                    @error('note')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="terms_editor" class="col-md-12 col-form-label text-md-start">{{ __('Terms and Condition') }}</label>
                                <div class="col-md-12">
                                    <div id="terms_editor" style="height: 300px;"></div>
                                    <textarea 
                                        class="d-none" 
                                        name="terms_and_conditions" 
                                        id="terms_editor_area"></textarea>
                                    @error('terms_and_conditions')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <label for="instructions_editor" class="col-md-12 col-form-label text-md-start">{{ __('Instructions') }}</label>
                                <div class="col-md-12">
                                    <div id="instructions_editor" style="height: 300px;"></div>
                                    <textarea 
                                        class="d-none" 
                                        name="instructions" 
                                        id="instructions_editor_area"></textarea>
                                    @error('instructions')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-4 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Initialize Quill editor -->
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Define editor configurations
            const editorConfigs = [
                {
                    editorId: 'terms_editor',
                    areaId: 'terms_editor_area'
                },
                {
                    editorId: 'instructions_editor',
                    areaId: 'instructions_editor_area'
                }
            ];
        
            // Common toolbar configuration
            const toolbarOptions = [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                ['link', 'image', 'video'],        
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                ['clean']
            ];
        
            // Initialize each editor
            editorConfigs.forEach(config => {
                const editorArea = document.getElementById(config.areaId);
                
                if (editorArea) {
                    const editor = new Quill(`#${config.editorId}`, {
                        theme: 'snow',
                        modules: {
                            toolbar: toolbarOptions
                        }
                    });
        
                    // Add text change listener
                    editor.on('text-change', function() {
                        editorArea.value = editor.root.innerHTML;
                    });
                }
            });
        });
        </script>
@endsection
