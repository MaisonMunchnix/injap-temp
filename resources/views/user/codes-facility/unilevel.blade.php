@extends('layouts.default.master')
@section('title','Unilevel Codes Facility')
@section('page-title','Unilevel Codes Facility')

@section('stylesheets')
{{-- additional style here --}}
@endsection

@section('content')
{{-- content here --}}
<div class="content-body">
    <div class="content">
        <div class="card">
            <div class="element-box">
                <div class="card-body">
                    <h5 class="form-header text-center">Product Codes Facility</h5>
                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addProductModal">+ Code</button>
                    <div class="table-responsive">
                        <table id="product_table" width="100%" class="table table-striped table-lightfont">
                            <thead>
                                <tr>
                                    <th>Codes</th>
                                    <th>Pin</th>
                                    <th>Product</th>
                                    <th>Updated Date</th>
                                    <th>Created date</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Codes</th>
                                    <th>Pin</th>
                                    <th>Product</th>
                                    <th>Updated Date</th>
                                    <th>Created date</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addProductModal" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <form action="" method="post" id="frm_productCode">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">Add Product Code</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="fom-group">
                                <label for="product_code">Product Code:*</label>
                                <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Product Code" autocomplete="off" autofocus required>
                            </div>
                            <div class="fom-group">
                                <label for="pin">PIN:*</label>
                                <input type="number" class="form-control" name="pin" id="pin" placeholder="PIN" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- additional scripts here --}}
<script>
    $(document).ready(function() {
        var save_code = "{{route('save-product-codes')}}";

        $('#product_table').DataTable({
            "order": [
                [4, "desc"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            processing: true,
            serverSide: true,
            "ajax": {
                "url": "{{ route('get-codes') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token,
                    type: 'product'
                }
            },
            "columns": [{
                    "data": "code"
                },
                {
                    "data": "security_pin"
                },
                {
                    "data": "name"
                },
                {
                    "data": "updated_at"
                },
                {
                    "data": "created_at"
                }
            ]
        });

        $('body').on('submit', '#frm_productCode', function(event) {
            event.preventDefault();
            console.log('Product Add submitting...');
            $.ajax({
                url: save_code,
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('.send-loading').show();
                },
                success: function(response) {
                    $('.send-loading').hide();
                    swal({
                        title: 'Success!',
                        text: 'Successfully Added',
                        timer: 1000,
                        type: "success",
                    }, function() {
                        location.reload();
                    });

                },
                error: function(error) {
                    $('.send-loading').hide();
                    swal({
                        title: 'Error!',
                        text: "Error Msg: " + error.responseJSON.message + "",
                        //timer: 1000,
                        type: "error",
                    })
                }
            });
        });
    });

</script>
@endsection