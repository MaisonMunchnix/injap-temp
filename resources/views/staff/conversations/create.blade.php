@extends('layouts.default.admin.master')
@section('title','Create Conversation')

@section('stylesheets')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="content-body">
    <!-- start content- -->
    <div class="content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('staff.messages.index') }}">Messages</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">New Conversation</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="mb-4" style="position: relative; z-index: 10; padding-top: 20px;">Start New Conversation</h2>

                <div class="card">
                    <div class="card-body">
                        <form id="conversation-form" method="POST" action="{{ route('staff.messages.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="member_id">Select Member <span class="text-danger">*</span></label>
                                <select class="form-control" id="member_id" name="member_id" required>
                                    <option value="">-- Choose a Member --</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}">{{ $member->username }} ({{ $member->email }})</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Select the member you want to message</small>
                            </div>

                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Optional conversation subject" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label for="message">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="6" required placeholder="Type your message here..." maxlength="5000"></textarea>
                                <small class="form-text text-muted">Max 5000 characters</small>
                            </div>

                            <!-- <div class="form-group">
                                <label for="attachments">Attachments (Optional)</label>
                                <input type="file" class="form-control-file" id="attachments" name="attachments[]" multiple>
                                <small class="form-text text-muted">Max 10MB per file</small>
                            </div> -->

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-send"></i> Send Message
                                </button>
                                <a href="{{ route('staff.messages.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end content- -->
</div>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    // Initialize Select2 for member dropdown
    $(document).ready(function() {
        $('#member_id').select2({
            placeholder: '-- Choose a Member --',
            allowClear: true,
            width: '100%',
            minimumInputLength: 0
        });
    });

    document.getElementById('conversation-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else if (data.errors) {
                let errorMsg = 'Validation errors:\n';
                for (let field in data.errors) {
                    errorMsg += data.errors[field].join(', ') + '\n';
                }
                alert(errorMsg);
            } else if (data.message) {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });
</script>
@endsection
