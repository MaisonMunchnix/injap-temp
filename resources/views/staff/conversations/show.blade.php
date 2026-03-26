@extends('layouts.default.admin.master')
@section('title','Conversation Details')

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
                    <li class="breadcrumb-item active" aria-current="page">Conversation with {{ $conversation->member->username }}</li>
                </ol>
            </nav>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <h3>Conversation with <strong>{{ $conversation->member->username }}</strong></h3>
                <small class="text-muted">Subject: {{ $conversation->subject ?? 'No Subject' }}<br>Member: {{ $conversation->member->email }}</small>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body" id="messages-container" style="height: 500px; overflow-y: auto; padding: 20px; background-color: #f8f9fa;">
                @foreach($messages as $message)
                    <div class="mb-3">
                        <div class="p-3 rounded" style="{% if $message->sender_id === auth()->id() %}background-color: #e3f2fd; text-align: right;{% else %}background-color: white; border-left: 4px solid #007bff;{% endif %}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <strong>{{ $message->sender->username }}</strong>
                                    <small class="text-muted d-block">{{ $message->created_at->format('M d, Y H:i') }}</small>
                                </div>
                                @if($message->is_read && $message->recipient_id === auth()->id())
                                    <small class="badge badge-info">Read</small>
                                @endif
                            </div>
                            <p class="mb-2">{{ $message->content }}</p>

                            @if($message->attachments->count() > 0)
                                <div class="mt-2 border-top pt-2">
                                    <strong>Attachments:</strong>
                                    <ul class="list-unstyled mb-0">
                                        @foreach($message->attachments as $attachment)
                                            <li>
                                                <a href="{{ route('staff.messages.download', $attachment->id) }}" class="btn btn-sm btn-link">
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
                <form id="reply-form" method="POST" action="{{ route('staff.messages.reply', $conversation->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="content">Message <span class="text-danger">*</span></label>
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
                    <a href="{{ route('staff.messages.index') }}" class="btn btn-secondary">Back to Conversations</a>
                </form>
            </div>
        </div>
    </div>
    <!-- end content- -->
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
            if (data.message === 'Message sent successfully') {
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
