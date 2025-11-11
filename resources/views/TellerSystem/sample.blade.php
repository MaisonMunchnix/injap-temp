<!-- Stored in resources/views/child.blade.php -->

@extends('TellerSystem.layouts.dashboard')

@section('title', 'Home')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
<div class="col-lg-4 card-body">
									<p><strong class="headings-color">New Registered Members</strong></p>
									<p class="text-muted">List of new members activated their account.</p>
								</div>
								<div class="col-lg-8 card-form__body">


									<div class="table-responsive border-bottom" data-toggle="lists" data-lists-values='["js-lists-values-employee-name"]'>

										<table class="table mb-0 thead-border-top-0">
											<thead>
												<tr>

													<th style="width: 18px;">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input js-toggle-check-all" data-target="#staff" id="customCheckAll">
															<label class="custom-control-label" for="customCheckAll"><span class="text-hide">Toggle all</span></label>
														</div>
													</th>

													<th>Employee</th>


													<th style="width: 37px;">Status</th>
													<th style="width: 120px;">Last Activity</th>
													<th style="width: 51px;">Earnings</th>
													<th style="width: 24px;"></th>
												</tr>
											</thead>
											<tbody class="list" id="staff">

												<tr class="selected">

													<td>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input js-check-selected-row" checked="" id="customCheck1_1">
															<label class="custom-control-label" for="customCheck1_1"><span class="text-hide">Check</span></label>
														</div>
													</td>

													<td>

														<div class="media align-items-center">
															<div class="avatar avatar-xs mr-2">
																<img src="assets/images/256_luke-porter-261779-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
															</div>
															<div class="media-body">

																<span class="js-lists-values-employee-name">Michael Smith</span>

															</div>
														</div>

													</td>


													<td><span class="badge badge-warning">ADMIN</span></td>
													<td><small class="text-muted">3 days ago</small></td>
													<td>&dollar;12,402</td>
													<td><a href="#" class="text-muted"><i class="material-icons">more_vert</i></a></td>
												</tr>
												<tr>

													<td>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck2_1">
															<label class="custom-control-label" for="customCheck2_1"><span class="text-hide">Check</span></label>
														</div>
													</td>

													<td>

														<div class="media align-items-center">
															<img src="assets/images/avatar/green.svg" class="mr-2" alt="avatar" />
															<div class="media-body">

																<span class="js-lists-values-employee-name">Connie Smith</span>

															</div>
														</div>

													</td>


													<td><span class="badge badge-success">USER</span></td>
													<td><small class="text-muted">1 week ago</small></td>
													<td>&dollar;1,943</td>
													<td><a href="#" class="text-muted"><i class="material-icons">more_vert</i></a></td>
												</tr>
												<tr>

													<td>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck3_1">
															<label class="custom-control-label" for="customCheck3_1"><span class="text-hide">Check</span></label>
														</div>
													</td>

													<td>

														<div class="media align-items-center">

															<div class="avatar avatar-xs mr-2">
																<img src="assets/images/256_daniel-gaffey-1060698-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
															</div>
															<div class="media-body">

																<span class="js-lists-values-employee-name">John Connor</span>

															</div>
														</div>

													</td>


													<td><span class="badge badge-primary">MANAGER</span></td>
													<td><small class="text-muted">1 week ago</small></td>
													<td>&dollar;1,943</td>
													<td><a href="#" class="text-muted"><i class="material-icons">more_vert</i></a></td>
												</tr>

												<tr class="selected">

													<td>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input js-check-selected-row" checked="" id="customCheck1_2">
															<label class="custom-control-label" for="customCheck1_2"><span class="text-hide">Check</span></label>
														</div>
													</td>

													<td>

														<div class="media align-items-center">
															<div class="avatar avatar-xs mr-2">
																<img src="assets/images/256_luke-porter-261779-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
															</div>
															<div class="media-body">

																<span class="js-lists-values-employee-name">Michael Smith</span>

															</div>
														</div>

													</td>


													<td><span class="badge badge-warning">ADMIN</span></td>
													<td><small class="text-muted">3 days ago</small></td>
													<td>&dollar;12,402</td>
													<td><a href="#" class="text-muted"><i class="material-icons">more_vert</i></a></td>
												</tr>
												<tr>

													<td>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck2_2">
															<label class="custom-control-label" for="customCheck2_2"><span class="text-hide">Check</span></label>
														</div>
													</td>

													<td>

														<div class="media align-items-center">
															<img src="assets/images/avatar/green.svg" class="mr-2" alt="avatar" />
															<div class="media-body">

																<span class="js-lists-values-employee-name">Connie Smith</span>

															</div>
														</div>

													</td>


													<td><span class="badge badge-success">USER</span></td>
													<td><small class="text-muted">1 week ago</small></td>
													<td>&dollar;1,943</td>
													<td><a href="#" class="text-muted"><i class="material-icons">more_vert</i></a></td>
												</tr>
												<tr>

													<td>
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input js-check-selected-row" id="customCheck3_2">
															<label class="custom-control-label" for="customCheck3_2"><span class="text-hide">Check</span></label>
														</div>
													</td>

													<td>

														<div class="media align-items-center">

															<div class="avatar avatar-xs mr-2">
																<img src="assets/images/256_daniel-gaffey-1060698-unsplash.jpg" alt="Avatar" class="avatar-img rounded-circle">
															</div>
															<div class="media-body">

																<span class="js-lists-values-employee-name">John Connor</span>

															</div>
														</div>

													</td>


													<td><span class="badge badge-primary">MANAGER</span></td>
													<td><small class="text-muted">1 week ago</small></td>
													<td>&dollar;1,943</td>
													<td><a href="#" class="text-muted"><i class="material-icons">more_vert</i></a></td>
												</tr>

											</tbody>
										</table>
									</div>


								</div>
@endsection