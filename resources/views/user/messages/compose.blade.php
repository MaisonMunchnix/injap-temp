@extends('layouts.default.master')
@section('title','Compose Message')

@section('content')
<div class="container mt-5 pt-5 py-5">
    <div class="row mb-3">
        <div class="col-md-12">
            <a href="{{ route('user.messages.inbox') }}" class="btn btn-secondary btn-sm mb-3">
                <i class="fa fa-arrow-left"></i> Back to Inbox
            </a>
            <h3>Send Message to Staff</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="compose-form" method="POST" action="{{ route('user.messages.store') }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="admin_id" value="{{ $admins->first()->id ?? '' }}">

                <div class="form-group">
                    <label><strong>Sending to Staff:</strong></label>
                </div>

                <div class="form-group">
                    <label for="subject">Subject <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="subject" name="subject" required placeholder="Enter subject" maxlength="255">
                    <small class="form-text text-muted">Max 255 characters</small>
                </div>

                <div class="form-group">
                    <label for="content">Message <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="content" name="content" rows="6" required placeholder="Type your message..." maxlength="5000"></textarea>
                    <small class="form-text text-muted">Max 5000 characters</small>
                </div>

                <!-- <div class="form-group">
                    <label for="attachments">Attachments (Optional)</label>
                    <input type="file" class="form-control-file" id="attachments" name="attachments[]" multiple>
                    <small class="form-text text-muted">Max 10MB per file</small>
                </div> -->

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-send"></i> Send Message
                </button>
                <a href="{{ route('user.messages.inbox') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('compose-form').addEventListener('submit', function(e) {
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
            if (data.message === 'Message sent successfully') {
                alert('Message sent!');
                window.location.href = '{{ route("user.messages.show", "") }}/' + data.conversation_id;
            } else if (data.errors) {
                alert('Validation errors: ' + JSON.stringify(data.errors));
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });
</script>
@endsection
