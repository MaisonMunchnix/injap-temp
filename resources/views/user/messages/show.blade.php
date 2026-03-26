@extends('layouts.default.master')
@section('title','Messages Details')
@section('content')
<div class="container mt-5 pt-5 py-5">
    <a href="{{ route('user.messages.inbox') }}" class="btn btn-secondary btn-sm mb-3">
                        <i class="fa fa-arrow-left"></i> Back to Inbox
                    </a>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    
                    <h3>Message from <strong>{{ $conversation->admin->username }}</strong></h3>
                    <small class="text-muted">Subject: {{ $conversation->subject ?? 'No Subject' }} | {{ $conversation->admin->email }}</small>
                </div>
                <a href="{{ route('user.messages.compose') }}" class="btn btn-primary btn-sm" title="Send a new message">
                    <i class="fa fa-plus"></i> New Message
                </a>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body" id="messages-container" style="height: 500px; overflow-y: auto; padding: 20px; background-color: #f8f9fa;">
            @foreach($messages as $message)
                <div class="mb-3">
                    <div class="p-3 rounded" style="{% if $message->sender_id === auth()->id() %}background-color: #c8e6c9; text-align: right;{% else %}background-color: white; border-left: 4px solid #4caf50;{% endif %}">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <strong>{{ $message->sender->username }}</strong>
                                <small class="text-muted d-block">{{ $message->created_at->format('M d, Y H:i') }}</small>
                            </div>
                        </div>
                        <p class="mb-2">{{ $message->content }}</p>

                        @if($message->attachments->count() > 0)
                            <div class="mt-2 border-top pt-2">
                                <strong>Attachments:</strong>
                                <ul class="list-unstyled mb-0">
                                    @foreach($message->attachments as $attachment)
                                        <li>
                                            <a href="{{ route('user.messages.download', $attachment->id) }}" class="btn btn-sm btn-link">
                                                <i class="fa fa-download"></i> {{ $attachment->filename }} ({{ $attachment->getHumanFileSize() }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mb-3">
        {{ $messages->links() }}
    </div>

    <!-- Reply Form -->
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">Send Reply</h5>
        </div>
        <div class="card-body">
            <form id="reply-form" method="POST" action="{{ route('user.messages.reply', $conversation->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="content">Your Message <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="content" name="content" rows="4" required placeholder="Type your reply..." maxlength="5000"></textarea>
                    <small class="form-text text-muted">Max 5000 characters</small>
                </div>

                <!-- <div class="form-group">
                    <label for="attachments">Attachments (Optional)</label>
                    <input type="file" class="form-control-file" id="attachments" name="attachments[]" multiple>
                    <small class="form-text text-muted">Max 10MB per file</small>
                </div> -->

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-send"></i> Send Reply
                </button>
                <a href="{{ route('user.messages.inbox') }}" class="btn btn-secondary">Back to Inbox</a>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('reply-form').addEventListener('submit', function(e) {
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
            if (data.message === 'Reply sent successfully') {
                alert('Reply sent!');
                location.reload();
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

    // Scroll to bottom of messages
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
</script>
@endsection
