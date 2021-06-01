@extends('layouts.template')

@section('title') Blog @endsection

@section('content')
<div class="app-page-title">
	<div class="page-title-wrapper">
		<div class="page-title-heading">
			<div class="page-title-icon">
				<i class="pe-7s-note2 icon-gradient bg-mean-fruit">
				</i>
			</div>
			<div>Blog
				<div class="page-title-subheading">Management blog.
				</div>
			</div>
		</div>
		<div class="page-title-actions">
			<div class="d-inline-block dropdown">
				<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
					<span class="btn-icon-wrapper pr-2 opacity-7">
						<i class="fa fa-business-time fa-w-20"></i>
					</span>
					Buttons
				</button>
				<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
					<ul class="nav flex-column">
						<li class="nav-item">
							<a href="javascript:void(0);" class="nav-link">
								<i class="nav-link-icon lnr-inbox"></i>
								<span>
									Inbox
								</span>
								<div class="ml-auto badge badge-pill badge-secondary">86</div>
							</a>
						</li>
						<li class="nav-item">
							<a href="javascript:void(0);" class="nav-link">
								<i class="nav-link-icon lnr-book"></i>
								<span>
									Book
								</span>
								<div class="ml-auto badge badge-pill badge-danger">5</div>
							</a>
						</li>
						<li class="nav-item">
							<a href="javascript:void(0);" class="nav-link">
								<i class="nav-link-icon lnr-picture"></i>
								<span>
									Picture
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a disabled href="javascript:void(0);" class="nav-link disabled">
								<i class="nav-link-icon lnr-file-empty"></i>
								<span>
									File Disabled
								</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>    
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="main-card mb-3 card">
			<div class="card-body"><h5 class="card-title">Table responsive</h5>
				<div class="table-responsive">
					<table class="mb-0 table">
						<thead>
							<tr>
								<th>#</th>
								<th>Table heading</th>
								<th>Table heading</th>
								<th>Table heading</th>
								<th>Table heading</th>
								<th>Table heading</th>
								<th>Table heading</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>Table cell</td>
								<td>Table cell</td>
								<td>Table cell</td>
								<td>Table cell</td>
								<td>Table cell</td>
								<td><button class="btn btn-info btn-sm"><i class="nav-link-icon pe-7s-eyedropper"></i></button>
									<button class="btn btn-danger btn-sm"><i class="nav-link-icon pe-7s-trash"></i></button></td>
							</tr>
							<tr>
								<th scope="row">2</th>
								<td>Table cell</td>
								<td>Table cell</td>
								<td>Table cell</td>
								<td>Table cell</td>
								<td>Table cell</td>
								<td>Table cell</td>
							</tr>
							<tr>
								<th scope="row">3</th>
								<td>Table cell</td>
								<td>Table cell</td>
								<td>Table cell</td>
								<td>Table cell</td>
								<td>Table cell</td>
								<td>Table cell</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection