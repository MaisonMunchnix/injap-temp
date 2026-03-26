@extends('layouts.default.master')
@section('title','Payment Upload')
@section('page-title','Payment Upload')

@section('content')
<div class="content-body">
    <div class="content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Payment Upload</li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Payment Upload</h4>
            </div>
            <div class="card-body">
        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Upload Form -->
        <div class="mb-4">
            <h5>Upload Your Payment</h5>
            <form action="{{ route('user.payments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="attachment" class="form-label">Choose File</label>
                    <input type="file" class="form-control @error('attachment') is-invalid @enderror" 
                        id="attachment" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif" required>
                    <small class="form-text text-muted">
                        Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG, GIF (Max 10MB)
                    </small>
                    @error('attachment')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="notes" class="form-label">Notes (Optional)</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                        id="notes" name="notes" rows="3" placeholder="Add any additional notes about this payment..."></textarea>
                    <small class="form-text text-muted">
                        Maximum 500 characters
                    </small>
                    @error('notes')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    <i data-feather="upload"></i> Upload Payment
                </button>
            </form>
        </div>

        <hr>

        <!-- Payments Table -->
        <h5>Your Payment History</h5>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>User Name</th>
                        <th>Upload Date</th>
                        <th>Attachment</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <td>
                                <span class="font-weight-bold">{{ $payment->user_name }}</span>
                            </td>
                            <td>
                                {{ $payment->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td>
                                <a href="{{ route('user.payments.download', $payment->id) }}" 
                                    class="btn btn-sm btn-info" title="Download">
                                    <i data-feather="download"></i>
                                    {{ $payment->original_filename }}
                                </a>
                            </td>
                            <td>
                                @if ($payment->status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif ($payment->status === 'approved')
                                    <span class="badge badge-success">Approved</span>
                                @elseif ($payment->status === 'rejected')
                                    <span class="badge badge-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                @if ($payment->notes)
                                    <small class="text-muted">{{ $payment->notes }}</small>
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                            <td>
                                @if ($payment->status === 'pending')
                                    <form action="{{ route('user.payments.destroy', $payment->id) }}" 
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure?')">
                                            <i data-feather="trash-2"></i> Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No payments uploaded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
            </div>
        </div>

        @include('layouts.default.footer')
    </div>
</div>
@endsection
