@extends('layouts.default.teller.master')
@section('title','Teller')
@section('page-title','Teller')

@section('stylesheets')
{{-- additional style here --}}
@endsection

@section('content')
<div class="content-body">
    <div class="content">
<div class="card">
                        <div class="card-body">
                             <!-- <h6 class="card-title">Header and footer</h6> -->
                            <div class="row">
                         
                    
                        <div class="col-md-6">
                            <div class="card shadow-none border mb-0">
                                <div class="card-header">
                                    Process Order
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">All Order</h5>
                                    
                                    <a href="{!! url('tellers/process-order') !!}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                   

                     
                    
                        <div class="col-md-6">
                            <div class="card shadow-none border mb-0">
                                <div class="card-header">
                                    Record Sales
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">All Record Sales</h5>
                                   
                                      <a class="btn btn-primary" href="{!! url('tellers/record-sales') !!}">View Details</a>
                                </div>
                            </div>
                        </div>
                    
                                
                                </div>

                            
                        </div>
					</div>


					<!-- <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h6 class="card-title">Top Selling Products</h6>
                <div>
                    <a href="#" class="btn btn-outline-light btn-sm mr-2">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <div class="dropdown">
                        <a href="#" data-toggle="dropdown"
                           class="btn btn-outline-light btn-sm"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="recent-orders" class="table table-lg">
                            <thead>
                            <tr>
                                <th>Products</th>
                                <th>Product Code</th>
                                <th>SRP</th>
                                <th>Sales</th>
                                <th>Earnings</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <a href="#">Sample Perfume</a>
                                </td>
                                <td>
                                    <a href="#">ABC-123</a>
                                </td>
                                <td>
                                    <a href="#">P100</a>
                                </td>
                                <td>
                                    <a href="#">356</a>
                                </td>
                                <td>
                                    <a href="#">P35,600</a>
                                </td>
                            </tr>
                          
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 -->


	
					</div>
					</div>
					
@endsection

@section('scripts')
<script>
	var token = "{{csrf_token()}}";
</script>
@endsection
