@extends('layouts.default.admin.master')
@section('title','Inbox')

@section('content')
<div class="content-body">
    <!-- start content- -->
    <div class="content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Messages</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Conversations</li>
                </ol>
            </nav>
        </div>

        <div class="row mb-3">
            <div class="col-md-8">
                <h2>Messages & Conversations</h2>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('staff.messages.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> New Conversation
                </a>
            </div>
        </div>

    @if($conversations->count() > 0)
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Member</th>
                            <th>Subject</th>
                            <th>Latest Message</th>
                            <th>Last Activity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($conversations as $conversation)
                            <tr>
                                <td>
                                    <strong>{{ $conversation->member->username }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $conversation->member->email }}</small>
                                </td>
                                <td>{{ $conversation->subject ?? 'No Subject' }}</td>
                                <td>
                                    @if($conversation->latestMessage)
                                        <small>
                                            {{ substr($conversation->latestMessage->content, 0, 50) }}{{ strlen($conversation->latestMessage->content) > 50 ? '...' : '' }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    {{ $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : 'N/A' }}
                                </td>
                                <td>
                                    <span class="badge badge-{{ $conversation->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($conversation->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('staff.messages.show', $conversation->id) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $conversation->id }}" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $conversation->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this conversation with
                                                    <strong>{{ $conversation->member->username }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <form method="POST" action="{{ route('staff.messages.destroy', $conversation->id) }}" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $conversations->links() }}
        </div>
    @else
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> No conversations yet.
            <a href="{{ route('staff.messages.create') }}" class="alert-link">Start a new conversation</a>
        </div>
    @endif
    </div>
    <!-- end content- -->
</div>
@endsection
