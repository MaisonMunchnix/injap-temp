@extends('layouts.user.master')
@section('title', 'Affiliate')
@section('page-title', 'Affiliate ')

@section('stylesheets')
    {{-- additional style here --}}
@endsection

@section('content')
    {{-- content here --}}
    <div class="content-i">
        <div class="content-box">
            <div class="element-wrapper">
                <!-- <h6 class="element-header">Data Tables</h6> -->
                <div class="element-box">
                    <h5 class="form-header text-center">
                        @if ($type === 'membership')
                            Membership Affiliate Links
                        @else
                            Product Retail Affiliate Links
                        @endif
                    </h5>
                    <div class="form-desc text-center">Copy this link and give it to your friends.</div>
                    @if (!empty($aff_link))
                        <div class="input-group mb-3">
                            <input type="text" name="aff_link" id="aff_link" value="{{ $aff_link }}"
                                class="form-control" readOnly>
                            <div class="input-group-append">
                                <button class="btn btn-primary input-group-button" id="btn-copy-link">Copy</button>
                            </div>
                        </div>
                    @else
                        <div class="input-group mb-3">
                            <input type="text" name="aff_link" id="aff_link" value="" class="form-control"
                                readOnly>
                            <div class="input-group-append">
                                <button class="btn btn-primary input-group-button" id="btn-copy-link">Copy</button>
                            </div>
                        </div>
                    @endif
                </div>
                @if ($type === 'membership')
                    <div class="element-box">
                        <h5 class="form-header text-center">Member who used your link to register</h5>
                        <div class="table-responsive">
                            <table id="affiliate_table" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Registered Date</th>
                                        <th>Account Type</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Registered Date</th>
                                        <th>Account Type</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if (!empty($member_data))
                                        @php $count=0; @endphp
                                        @foreach ($member_data as $data)
                                            @php $count++; @endphp
                                            <tr style="text-transform: capitalize">
                                                <td>{{ $count }}</td>
                                                <td>{{ $data->first_name }} {{ $data->last_name }}</td>
                                                <td>{{ date('F m, Y', strtotime($data->created_at)) }}</td>
                                                <td>
                                                    @if (!empty($data->account_type))
                                                        {{ $package[$data->account_type] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->status == '2')
                                                        Inactive
                                                    @else
                                                        Active
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="element-box">
                        <h5 class="form-header text-center">Member who used your link to register</h5>
                        <div class="table-responsive">
                            <table id="retail_table" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Bought Date</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Bought Date</th>
                                        <th>Amount</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if (!empty($retail_data))
                                        @php $count=0; @endphp
                                        @foreach ($retail_data as $data)
                                            @php $count++; @endphp
                                            <tr style="text-transform: capitalize">
                                                <td>{{ $count }}</td>
                                                <td>{{ $data->first_name }} {{ $data->last_name }}</td>
                                                <td>{{ date('F m, Y', strtotime($data->created_at)) }}</td>
                                                <td class="numbers">{{ $data->subtotal }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            @include('user.customizer')
        </div>
    </div>



@endsection

@section('scripts')
    {{-- additional scripts here --}}
    <script>
        $('#affiliate_table').dataTable();
        $('#retail_table').dataTable();
        $(document).ready(function() {
            $('#affiliate_table_wrapper').removeClass('form-inline');
            $('#retail_table_wrapper').removeClass('form-inline');
            $('#btn-copy-link').click(function() {
                var copy_text = document.getElementById("aff_link");
                copy_text.select();
                copy_text.setSelectionRange(0, 99999);
                document.execCommand("copy");
            });
            $(".numbers").each(function() {
                var new_txt = $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                $(this).text(new_txt)
            });
        });
    </script>
@endsection
