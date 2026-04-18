@extends('layouts.student')

@section('stylesheets')
    <style>
        /* Override navbar to hide navigation during forced update */
        #studentNav {
            display: none !important;
        }

        .navbar-brand {
            pointer-events: none;
        }
    </style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="mb-5">
                <h2 class="font-weight-bold text-dark-blue">Secure Your Account</h2>
                <p class="text-secondary">Since this is your first time logging in, please update your temporary password to
                    something more secure.</p>
            </div>

            <div class="card student-card text-left border-0">
                <div class="card-body p-5">
                    <form action="{{ route('student.change-password.update') }}" method="POST">
                        @csrf

                        <div class="form-group mb-4">
                            <label class="font-weight-bold small text-uppercase mb-2 text-muted">New Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-0"><i
                                            class="fas fa-lock text-primary"></i></span>
                                </div>
                                <input type="password" name="password"
                                    class="form-control border-0 bg-light @error('password') is-invalid @enderror"
                                    placeholder="Min. 8 characters" required autofocus>
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold small text-uppercase mb-2 text-muted">Confirm New
                                Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-0"><i
                                            class="fas fa-check-double text-primary"></i></span>
                                </div>
                                <input type="password" name="password_confirmation" class="form-control border-0 bg-light"
                                    placeholder="Repeat password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-portal btn-block btn-lg py-3 shadow-lg"
                            style="background: linear-gradient(45deg, #4e73df, #224abe); border: none; font-size: 1.1rem;">
                            Update Password & Continue <i class="fas fa-shield-alt ml-2"></i>
                        </button>

                        <div class="text-center mt-4">
                            <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> You will be redirected to your
                                dashboard once updated.</small>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="btn btn-danger text-white font-weight-500">
                    <i class="fas fa-sign-out-alt mr-1"></i> Cancel and logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection