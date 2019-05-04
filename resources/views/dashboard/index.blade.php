@extends('dashboard.dashboard_layouts.app')

@section('dashboard_content')

		<section class="dashboard gray-bg padd-0 mrg-top-50">
			<div class="container-fluid">
				<div class="row">					
					<div class="col-lg-10 col-md-10 col-sm-9 col-lg-push-2 col-md-push-2 col-sm-push-3">
						<div class="row mrg-0 mrg-top-20">
							<div class="tr-single-box">
								<div class="tr-single-header">
									<h3 class="dashboard-title">Dashboard</h3>
								</div>
								<div class="tr-single-body">
								
									<!-- row -->
									<div class="row">
										<div class="col-md-3 col-sm-6">
											<div class="widget simple-widget">
												<div class="rwidget-caption info">
													<div class="row">
														<div class="col-xs-4 padd-r-0">
															<i class="cl-info icon ti-user"></i>
														</div>
														<div class="col-xs-8">
															<div class="widget-detail">
																<h3>372</h3>
																<span>New Users</span>
															</div>
														</div>
														<div class="col-xs-12">
															<div class="widget-line">
																<span style="width:80%;" class="bg-info widget-horigental-line"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="col-md-3 col-sm-6">
											<div class="widget simple-widget">
												<div class="widget-caption danger">
													<div class="row">
														<div class="col-xs-4 padd-r-0">
															<i class="cl-danger icon ti-shopping-cart-full"></i>
														</div>
														<div class="col-xs-8">
															<div class="widget-detail">
																<h3>412</h3>
																<span>Happy Customer</span>
															</div>
														</div>
														<div class="col-xs-12">
															<div class="widget-line">
																<span style="width:50%;" class="bg-danger widget-horigental-line"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="col-md-3 col-sm-6">
											<div class="widget simple-widget">
												<div class="widget-caption warning">
													<div class="row">
														<div class="col-xs-4 padd-r-0">
															<i class="cl-success icon ti-medall"></i>
														</div>
														<div class="col-xs-8">
															<div class="widget-detail">
																<h3>870</h3>
																<span>World Award</span>
															</div>
														</div>
														<div class="col-xs-12">
															<div class="widget-line">
																<span style="width:60%;" class="bg-success widget-horigental-line"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="col-md-3 col-sm-6">
											<div class="widget simple-widget">
												<div class="widget-caption purple">
													<div class="row">
														<div class="col-xs-4 padd-r-0">
															<i class="cl-purple icon ti-briefcase"></i>
														</div>
														<div class="col-xs-8">
															<div class="widget-detail">
																<h3>4770</h3>
																<span>Total Sales</span>
															</div>
														</div>
														<div class="col-xs-12">
															<div class="widget-line">
																<span style="width:40%;" class="bg-purple widget-horigental-line"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- /row -->
									
									<!-- row -->
									<div class="row">
										<div class="col-md-8 col-sm-12">
											<div class="tr-single-box">
												<div class="tr-single-header">
													<h4 class="mb-0">Extra Area Chart</h4>
												</div>
												<div class="tr-single-body">
													<ul class="list-inline text-center m-t-40">
														<li>
															<h5><i class="fa fa-circle m-r-5 cl-purple"></i>Booking 220</h5>
														</li>
														<li>
															<h5><i class="fa fa-circle m-r-5 cl-inverse"></i>Cancelation 20</h5>
														</li>
														<li>
															<h5><i class="fa fa-circle m-r-5 cl-success"></i>Earning $220</h5>
														</li>
													</ul>
													<div class="chart" id="extra-area-chart" style="height: 350px;"></div>
												</div>
											</div>
										</div>
										
										<div class="col-md-4 col-sm-12">
											<div class="tr-single-box">
												<div class="tr-single-header">
													<h5>Recen Booking</h5>
												</div>
												<div class="ground-list ground-list-hove">
													<div class="ground ground-single-list">
														<a href="#">
															<img class="ground-avatar" src="http://via.placeholder.com/420x420" alt="...">
															<span class="profile-status bg-online pull-right"></span>
														</a>

														<div class="ground-content">
															<h6><a href="#">Maryam Amiri</a></h6>
															<small class="text-fade">Co-Founder</small>
														</div>

														<div class="ground-right">
															<span class="small">Online</span>
														</div>
													</div>
													
													<div class="ground ground-single-list">
														<a href="#">
															<img class="ground-avatar" src="http://via.placeholder.com/420x420" alt="...">
															<span class="profile-status bg-offline pull-right"></span>
														</a>

														<div class="ground-content">
															<h6><a href="#">Maryam Amiri</a></h6>
															<small class="text-fade">Co-Founder</small>
														</div>

														<div class="ground-right">
															<span class="small">10 Min Ago</span>
														</div>
													</div>
													
													<div class="ground ground-single-list">
														<a href="#">
															<img class="ground-avatar" src="http://via.placeholder.com/420x420" alt="...">
															<span class="profile-status bg-working pull-right"></span>
														</a>

														<div class="ground-content">
															<h6><a href="#">Maryam Amiri</a></h6>
															<small class="text-fade">Co-Founder</small>
														</div>

														<div class="ground-right">
															<span class="small">20 Min Ago</span>
														</div>
													</div>
													
													<div class="ground ground-single-list">
														<a href="#">
															<img class="ground-avatar" src="http://via.placeholder.com/420x420" alt="...">
															<span class="profile-status bg-busy pull-right"></span>
														</a>

														<div class="ground-content">
															<h6><a href="#">Maryam Amiri</a></h6>
															<small class="text-fade">Co-Founder</small>
														</div>

														<div class="ground-right">
															<span class="small">18 Min Ago</span>
														</div>
													</div>
													
													<div class="ground ground-single-list">
														<a href="#">
															<img class="ground-avatar" src="http://via.placeholder.com/420x420" alt="...">
															<span class="profile-status bg-online pull-right"></span>
														</a>

														<div class="ground-content">
															<h6><a href="#">Maryam Amiri</a></h6>
															<small class="text-fade">Co-Founder</small>
														</div>

														<div class="ground-right">
															<span class="small">Online</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- /row -->
									
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</section>
		<!-- ======================= End Dashboard ===================== -->

@endsection
