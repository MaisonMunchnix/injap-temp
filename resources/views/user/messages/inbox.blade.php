@extends('layouts.default.master')
@section('title','Inbox')

@section('content')
<div class="container mt-5 pt-5 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Your Messages</h2>
        <a href="{{ route('user.messages.compose') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> New Message
        </a>
    </div>

    @if($conversations->count() > 0)
        <div class="card">
            <div class="list-group list-group-flush">
                @foreach($conversations as $conversation)
                    <a href="{{ route('user.messages.show', $conversation->id) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <strong>{{ $conversation->admin->username }}</strong>
                                    @if($conversation->unread_count > 0)
                                        <span class="badge badge-warning ml-2">{{ $conversation->unread_count }} new</span>
                                    @endif
                                </h6>
                                <p class="mb-1 text-muted">
                                    <strong>Subject:</strong> {{ $conversation->subject ?? 'No Subject' }}
                                </p>
                                @if($conversation->latestMessage)
                                    <small class="text-muted d-block">
                                        <strong>Latest:</strong> {{ substr($conversation->latestMessage->content, 0, 60) }}{{ strlen($conversation->latestMessage->content) > 60 ? '...' : '' }}
                                    </small>
                                @endif
                            </div>
                            <div class="text-right ml-3" style="white-space: nowrap;">
                                <small class="text-muted">
                                    <i class="fa fa-chevron-right"></i>
                                </small>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mt-4">
            {{ $conversations->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="fa fa-inbox" style="font-size: 48px; opacity: 0.3;"></i>
            <p class="mt-3">You have no messages yet.</p>
            <p class="text-muted">Messages from administrators will appear here.</p>
        </div>
    @endif
</div>
@endsection
