<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('admin/images/logo.png') }}" type="image/x-icon">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/fontawesome.min.css" integrity="sha512-cHxvm20nkjOUySu7jdwiUxgGy11vuVPE9YeK89geLMLMMEOcKFyS2i+8wo0FOwyQO/bL8Bvq1KMsqK4bbOsPnA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <title>MayurPaints </title>
	
	<style>
		.page-item.active .page-link {
			background-color: rgb(219, 110, 76);
			border-color: rgb(219, 110, 76);
		}
		.page-link, .page-link:hover, .page-link:focus {
			color: rgb(219, 110, 76);
			box-shadow: none;
		}
	</style>
</head>

<body>
    <aside class="side__bar shadow-sm">
        <div class="admin__logo">
            <div class="logo">
                {{-- <svg width="322" height="322" viewBox="0 0 322 322" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="231.711" y="47.8629" width="60" height="260" rx="30" transform="rotate(45 231.711 47.8629)" fill="#c10909" />
                    <rect x="236.66" y="137.665" width="60" height="180" rx="30" transform="rotate(45 236.66 137.665)" fill="#c10909" />
                    <rect x="141.908" y="42.9132" width="60" height="180" rx="30" transform="rotate(45 141.908 42.9132)" fill="#c10909" />
                </svg> --}}
                <img src="{{ asset('admin/images/logo.png') }}">
            </div>
            <div class="admin__info" style="width: 100% ; overflow : hidden" >
                <h1>{{ Auth()->guard('admin')->user()->name }}</h1>
                <p style="overflow : hidden;whitespace: narrow font-size:12px;font-size: 12px;" >{{ Auth()->guard('admin')->user()->email }}</p>
            </div>
        </div>

        <nav class="main__nav">
            <ul>
                <li class="{{ ( request()->is('admin/home*') ) ? 'active' : '' }}"><a href="{{ route('admin.home') }}"><i class="fi fi-br-home"></i> <span>Dashboard</span></a></li>

              
                {{-- user --}}
                 <li class="@if(request()->is('admin/user*')) { {{'active'}} }  @endif">
                    <a href="#"><i class="fi fi-br-cube"></i> <span>User</span></a>
                    <ul>
                        <li class="{{ ( request()->is('admin/user/painter*') ) ? 'active' : '' }}"><a href="{{ route('admin.user.painter.index') }}"><i class="fi fi-br-database"></i> <span>Painter</span></a></li>
                        <li class="{{ ( request()->is('admin/user/sales-person*') ) ? 'active' : '' }}"><a href="{{ route('admin.user.sales-person.index') }}"><i class="fi fi-br-database"></i> <span>Sales Person</span></a></li>
                        <li class="{{ ( request()->is('admin/user/customer*') ) ? 'active' : '' }}"><a href="{{ route('admin.user.customer.index') }}"><i class="fi fi-br-database"></i> <span>Customer</span></a></li>
                    </ul>
                </li> 

                {{-- master --}}
                <li class="@if(request()->is('admin/category*') || request()->is('admin/brochure*')) { {{'active'}} }  @endif">
                    <a href="#"><i class="fi fi-br-cube"></i> <span>Master</span></a>
                    <ul>
                        <li class="{{ ( request()->is('admin/category*') ) ? 'active' : '' }}"><a href="{{ route('admin.category.index') }}"><i class="fi fi-br-database"></i> <span>Category</span></a></li>
                        <li class="{{ ( request()->is('admin/brochure*') ) ? 'active' : '' }}"><a href="{{ route('admin.banner.index') }}"><i class="fi fi-br-database"></i> <span>Banner</span></a></li>
                    </ul>
                </li>
                    {{-- product --}}
                <li class="@if(request()->is('admin/product*') || request()->is('admin/faq*')) { {{'active'}} }  @endif">
                    <a href="#"><i class="fi fi-br-cube"></i> <span>Product</span></a>
                    <ul>
                        <li class="{{ ( request()->is('admin/product/list*') ) ? 'active' : '' }}"><a href="{{ route('admin.product.index') }}">All Product</a></li>

                        <li class="{{ ( request()->is('admin/product/create*') ) ? 'active' : '' }}"><a href="{{ route('admin.product.create') }}">Add New</a></li>
                    </ul>
                </li>
                <li class="{{ ( request()->is('admin/reward/product*') ) ? 'active' : '' }}"><a href="{{ route('admin.reward.product.index') }}"><i class="fi fi-br-database"></i> <span>Reward Product</span></a></li>
                <li class="{{ ( request()->is('admin/enquiry*') ) ? 'active' : '' }}"><a href="{{ route('admin.enquiry.index') }}"><i class="fi fi-br-database"></i> <span>Product Enquiry</span></a></li>
                <li class="{{ ( request()->is('admin/complaint*') ) ? 'active' : '' }}"><a href="{{ route('admin.complaint.index') }}"><i class="fi fi-br-database"></i> <span>Complaint</span></a></li>
                <li class="{{ ( request()->is('admin/qrcode*') ) ? 'active' : '' }}"><a href="{{ route('admin.qrcode.index') }}"><i class="fi fi-br-database"></i> <span>QR code</span></a></li>
				<li class="{{ ( request()->is('admin/order*') ) ? 'active' : '' }}"><a href="{{ route('admin.order.index') }}"><i class="fi fi-br-database"></i> <span>Order</span></a></li>

                <li class="{{ ( request()->is('admin/chat*') ) ? 'active' : '' }}"><a href="{{ route('admin.chat.index') }}"><i class="fi fi-br-database"></i> <span>Chat</span></a></li> 
                <li class="{{ ( request()->is('admin/about*') ) ? 'active' : '' }}"><a href="{{ route('admin.about.index') }}"><i class="fi fi-br-database"></i> <span>About us</span></a></li> 
            </ul>
        </nav>
         <div class="nav__footer">
            <a href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fi fi-br-cube"></i> <span>Log Out</span></a>
        </div>
    </aside>
    <main class="admin">
       <header>
            <div class="row align-items-center">
                <div class="col-auto ms-auto">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::guard('admin')->user()->name }}
                        </button>
                        <ul class="dropdown-menu test" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="{{route('admin.admin.profile')}}">Profile</a></li>
                            <li> <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
								<i class="fi fi-br-sign-out"></i> 
								<span>Logout</span>
								</a>
							</li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <section class="admin__title">
            <h1>@yield('page')</h1>
        </section>

        @yield('content')

        <footer>
            <div class="row">
                <div class="col-12 text-end">MayurPaints-{{date('Y')}}</div>
            </div>
        </footer>
    </main>

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">@csrf</form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <script type="text/javascript" src="{{ asset('admin/js/custom.js') }}"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
		// tooltip
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		  return new bootstrap.Tooltip(tooltipTriggerEl)
		})

        // click to select all checkbox
        function headerCheckFunc() {
            if ($('#flexCheckDefault').is(':checked')) {
                $('.tap-to-delete').prop('checked', true);
                clickToRemove();
            } else {
                $('.tap-to-delete').prop('checked', false);
                clickToRemove();
            }
        }

        // sweetalert fires | type = success, error, warning, info, question
        function toastFire(type = 'success', title, body = '') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 2000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: type,
                title: title,
                // text: body
            })
        }

        // on session toast fires
        @if (Session::get('success'))
            toastFire('success', '{{ Session::get('success') }}');
        @elseif (Session::get('failure'))
            toastFire('warning', '{{ Session::get('failure') }}');
        @endif
    </script>

    @yield('script')
</body>
</html>
