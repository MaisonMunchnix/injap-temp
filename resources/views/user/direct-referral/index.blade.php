@extends('layouts.default.master')
@section('title', 'Direct Referral')
@section('page-title', 'Direct Referral')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
    {{-- content here --}}
    <div class="content-body">
        <div class="content">
            <div class="card">
                <!-- <h6 class="element-header">Data Tables</h6> -->
                <div class="card-body">
                    <h5 class="form-header text-center">Direct Referral</h5>
                    <div class="form-desc text-center">Total Direct referral @if (!empty($result_data))
                            @php echo count($result_data); @endphp
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table id="direct_referral_tbl" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Account Type</th>
                                    <th>Placement</th>
                                    <th>Placement Position</th>
                                    <th>Registered Date</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Account Type</th>
                                    <th>Placement</th>
                                    <th>Placement Position</th>
                                    <th>Registered Date</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (!empty($result_data))
                                    @foreach ($result_data as $key_data => $value_data)
                                        <tr class="text-capitalize">
                                            <td>{{ $value_data['name'] }}</td>
                                            <td>{{ $value_data['acc_type'] }}</td>
                                            <td>{{ $value_data['placement'] }}</td>
                                            <td>{{ $value_data['placement_position'] }}</td>
                                            <td>{{ $value_data['reg_date'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>

                        </table>

                    </div>

                </div>


            </div>

            @include('user.customizer')

        </div>
    </div>

@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <script>
        $('#direct_referral_tbl').dataTable();
        /* $(document).ready(function(){
            $('#direct_referral_tbl_wrapper').removeClass('form-inline');
        }); */
    </script>
@endsection
