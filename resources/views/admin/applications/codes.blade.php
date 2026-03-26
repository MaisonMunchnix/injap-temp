@extends('layouts.default.admin.master')
@section('title', 'Product Code Generator')
@section('page-title', 'Application Product Codes')

@section('stylesheets')
    <style>
        .code-list-table th {
            background-color: #f8f9fa;
        }
        .code-display {
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            font-size: 1.1em;
            letter-spacing: 1px;
        }
        .status-badge {
            font-size: 0.8em;
            text-transform: uppercase;
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <div class="content">
            <div class="card">
                <div class="card-body">
                    <div class="element-info">
                        <div class="element-info-with-icon">
                            <div class="element-info-icon"><i data-feather="grid"></i></div>
                            <div class="element-info-text">
                                <h5 class="element-inner-header">@yield('title')</h5>
                                <div class="element-inner-desc">Generate 8-digit unique codes for clients to use in the application form. Each click generates 10 new codes.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form action="{{ route('applications.generate-codes') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Generate 10 new unique 8-digit codes?')">
                                    <i class="os-icon os-icon-plus"></i> Generate 10 New Codes
                                </button>
                            </form>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-lg code-list-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Code</th>
                                    <th>Status</th>
                                    <th>Used By</th>
                                    <th>Created At</th>
                                    <th>Used At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($codes as $code)
                                    <tr>
                                        <td>{{ $loop->iteration + ($codes->currentPage() - 1) * $codes->perPage() }}</td>
                                        <td>
                                            <span class="code-display text-primary">{{ $code->code }}</span>
                                        </td>
                                        <td>
                                            @if($code->is_used)
                                                <span class="badge badge-danger status-badge">Used</span>
                                            @else
                                                <span class="badge badge-success status-badge">Available</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($code->user)
                                                {{ $code->user->info->first_name ?? '' }} ({{ $code->user->username }})
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $code->created_at->format('M d, Y H:i A') }}</td>
                                        <td>
                                            @if($code->is_used)
                                                {{ $code->updated_at->format('M d, Y H:i A') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No codes generated yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        {{ $codes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
@endsection
