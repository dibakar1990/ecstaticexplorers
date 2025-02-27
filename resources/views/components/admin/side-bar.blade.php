<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				@if(setting()->file_path != '')
				<div>
					<img src="{{ setting()->file_path_url }}" class="logo-icon" alt="logo icon">
				</div>
				@endif
				<div>
					@php
						$title = setting()->app_title ?? config('app.name');
					@endphp
					<h4 class="logo-text">{{ $title }}</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
				</div>
			 </div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
			    @if(Auth::guard('admin')->user()->is_super_admin == 1) 
				<li>
					<a href="{{ route('admin.dashboard') }}">
						<div class="parent-icon"><i class='bx bx-home-alt'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
				<li class="{{ (request()->is('admin/banners*')) ? 'mm-active' : '' }}">
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-images"></i>
						</div>
						<div class="menu-title">Banner Manage</div>
					</a>
					<ul class="{{ (request()->is('admin/banners*')) ? 'mm-show' : '' }}">
						<li class="{{ (request()->is('admin/banners')) ? 'mm-active' : '' }}"> <a href="{{route('admin.banners.index')}}"><i class='bx bx-radio-circle'></i>Banners</a>
						</li>
						<li class="{{ (request()->is('admin/banners/create')) ? 'mm-active' : '' }}"> <a href="{{ route('admin.banners.create') }}"><i class='bx bx-radio-circle'></i>Create</a>
						</li>
					</ul>
				</li>
				<li class="{{ (request()->is('admin/galleries*')) ? 'mm-active' : '' }}">
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-images"></i>
						</div>
						<div class="menu-title">Gallery Manage</div>
					</a>
					<ul class="{{ (request()->is('admin/galleries*')) ? 'mm-show' : '' }}">
						<li class="{{ (request()->is('admin/galleries')) ? 'mm-active' : '' }}"> <a href="{{route('admin.galleries.index')}}"><i class='bx bx-radio-circle'></i>Gallery</a>
						</li>
						<li class="{{ (request()->is('admin/galleries/create')) ? 'mm-active' : '' }}"> <a href="{{ route('admin.galleries.create') }}"><i class='bx bx-radio-circle'></i>Create</a>
						</li>
					</ul>
				</li>
				<li class="{{ (request()->is('admin/pakages*') || (request()->is('admin/categories*')) || (request()->is('admin/states*')) || (request()->is('admin/cities*')) || (request()->is('admin/tag*')) || (request()->is('admin/language*')) || (request()->is('admin/types*'))) ? 'mm-active' : '' }}">
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fas fa-clipboard-list"></i>
						</div>
						<div class="menu-title">Package Manage</div>
					</a>
					<ul class="{{ (request()->is('admin/pakages*') || (request()->is('admin/categories*')) || (request()->is('admin/states*')) || (request()->is('admin/cities*')) || (request()->is('admin/tag*')) || (request()->is('admin/language*')) || (request()->is('admin/types*'))) ? 'mm-show' : '' }}">
						<li class="{{ (request()->is('admin/pakages*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.pakages.index')}}"><i class='bx bx-radio-circle'></i>Package</a>
						</li>
						<li class="{{ (request()->is('admin/categories*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.categories.index')}}"><i class='bx bx-radio-circle'></i>Category</a>
						</li>
						<li class="{{ (request()->is('admin/states*')) ? 'mm-active' : '' }}"> <a href="{{ route('admin.states.index') }}"><i class='bx bx-radio-circle'></i>State</a>
						</li>
						<li class="{{ (request()->is('admin/cities*')) ? 'mm-active' : '' }}"> <a href="{{ route('admin.cities.index') }}"><i class='bx bx-radio-circle'></i>City</a>
						</li>
						<li class="{{ (request()->is('admin/tag*')) ? 'mm-active' : '' }}"> <a href="{{ route('admin.tag.index') }}"><i class='bx bx-radio-circle'></i>Tag</a>
						</li>
						<li class="{{ (request()->is('admin/types*')) ? 'mm-active' : '' }}"> <a href="{{ route('admin.types.index') }}"><i class='bx bx-radio-circle'></i>Type</a>
						</li>
						<li class="{{ (request()->is('admin/language*')) ? 'mm-active' : '' }}"> <a href="{{ route('admin.language.index') }}"><i class='bx bx-radio-circle'></i>Language</a>
						</li>
					</ul>
				</li>
				<li class="{{ (request()->is('admin/homestays*') || (request()->is('admin/locations*'))) ? 'mm-active' : '' }}">
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fas fa-clipboard-list"></i>
						</div>
						<div class="menu-title">Homestay Manage</div>
					</a>
					<ul class="{{ (request()->is('admin/homestays*') || (request()->is('admin/locations*'))) ? 'mm-show' : '' }}">
						<li class="{{ (request()->is('admin/homestays*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.homestays.index')}}"><i class='bx bx-radio-circle'></i>Homestay</a>
						</li>
						<li class="{{ (request()->is('admin/locations*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.locations.index')}}"><i class='bx bx-radio-circle'></i>Location</a>
						</li>
					</ul>
				</li>
				
				<li class="{{ (request()->is('admin/blogs*') || (request()->is('admin/category*')) || (request()->is('admin/tags*'))) ? 'mm-active' : '' }}">
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fas fa-blog"></i>
						</div>
						<div class="menu-title">Blog Manage</div>
					</a>
					<ul class="{{ (request()->is('admin/blogs*') || (request()->is('admin/category*')) || (request()->is('admin/tags*'))) ? 'mm-show' : '' }}">
						<li class="{{ (request()->is('admin/blogs*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.blogs.index')}}"><i class='bx bx-radio-circle'></i>Blogs</a>
						</li>
						<li class="{{ (request()->is('admin/category*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.category.index')}}"><i class='bx bx-radio-circle'></i>Category</a>
						</li>
						<li class="{{ (request()->is('admin/tags*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.tags.index')}}"><i class='bx bx-radio-circle'></i>Tags</a>
						</li>
					</ul>
				</li>
				<li class="{{ (request()->is('admin/pages*')) ? 'mm-active' : '' }}">
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fas fa-pager"></i>
						</div>
						<div class="menu-title">CMS Manage</div>
					</a>
					<ul class="{{ (request()->is('admin/pages*')) ? 'mm-show' : '' }}">
						<li class="{{ (request()->is('admin/pages*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.pages.index')}}"><i class='bx bx-radio-circle'></i>Pages</a>
						</li>
						
						
					</ul>
				</li>
				<li class="{{ (request()->is('admin/contacts*')) || (request()->is('admin/newsletter*')) ? 'mm-active' : '' }}">
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fas fa-address-book"></i>
						</div>
						<div class="menu-title">Contact Manage</div>
					</a>
					<ul class="{{ (request()->is('admin/contacts*')) || (request()->is('admin/newsletter*')) ? 'mm-show' : '' }}">
						<li class="{{ (request()->is('admin/contacts*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.contacts.index')}}"><i class='bx bx-radio-circle'></i>Contacts</a>
						</li>
						<li class="{{ (request()->is('admin/newsletter*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.newsletter.index')}}"><i class='bx bx-radio-circle'></i>Newsletter</a>
						</li>
						
					</ul>
				</li>
				<li>
					<a href="{{ route('admin.quotes') }}">
						<div class="parent-icon"><i class="bx bx-file"></i></div>
						<div class="menu-title">Quotes</div>
					</a>  
				</li>
				<li>
					<a href="{{ route('admin.users') }}">
						<div class="parent-icon"><i class="bx bx-user"></i></div>
						<div class="menu-title">Users</div>
					</a> 
				</li> 
				<li class="menu-label">{{ __('System Setting') }}</li>
        
				<li class="{{ (request()->is('admin/application-setting*') || request()->is('admin/socials*')) ? 'mm-active' : '' }}">
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='lni lni-cogs'></i>
						</div>
						<div class="menu-title">{{ __('Setting') }}</div>
					</a>
					<ul class="{{ (request()->is('admin/application-setting*') || request()->is('admin/socials*')) ? 'mm-show' : '' }}">
						<li class="{{ (request()->is('admin/application-setting')) ? 'mm-active' : '' }}"> <a href="{{route('admin.application.setting.index')}}"><i class="bx bx-right-arrow-alt"></i>{{ __('Application Setting') }}</a>
						</li>
						<li class="{{ (request()->is('admin/socials')) ? 'mm-active' : '' }}"> <a href="{{route('admin.socials.index')}}"><i class="bx bx-right-arrow-alt"></i>{{ __('Social Links') }}</a>
						</li>
					</ul>
				</li>
				<li class="menu-label">{{ __('Profile Setting') }}</li>
				<li>
					<a href="{{ route('admin.profile.index') }}">
						<div class="parent-icon"><i class="bx bx-user-circle"></i>
						</div>
						<div class="menu-title">{{ __('User Profile') }}</div>
					</a>
				</li>
				<li>
					<a href="{{ route('admin.change.password') }}">
						<div class="parent-icon"><i class="lni lni-unlock"></i>
						</div>
						<div class="menu-title">{{ __('Change Password') }}</div>
					</a>
				</li>
				<li>
					<a href="{{route('admin.logout')}}">
						<div class="parent-icon"><i class="bx bx-log-out-circle"></i>
						</div>
						<div class="menu-title">{{ __('Logout') }}</div>
					</a>
					
				</li>
				@else
				<li>
					<a href="{{ route('admin.dashboard') }}">
						<div class="parent-icon"><i class='bx bx-home-alt'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
				<li class="{{ (request()->is('admin/banners*')) ? 'mm-active' : '' }}">
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-images"></i>
						</div>
						<div class="menu-title">Banner Manage</div>
					</a>
					<ul class="{{ (request()->is('admin/banners*')) ? 'mm-show' : '' }}">
						<li class="{{ (request()->is('admin/banners')) ? 'mm-active' : '' }}"> <a href="{{route('admin.banners.index')}}"><i class='bx bx-radio-circle'></i>Banners</a>
						</li>
						<li class="{{ (request()->is('admin/banners/create')) ? 'mm-active' : '' }}"> <a href="{{ route('admin.banners.create') }}"><i class='bx bx-radio-circle'></i>Create</a>
						</li>
					</ul>
				</li>
				<li class="{{ (request()->is('admin/pakages*') || (request()->is('admin/categories*')) || (request()->is('admin/states*')) || (request()->is('admin/cities*')) || (request()->is('admin/tag*')) || (request()->is('admin/language*')) || (request()->is('admin/types*'))) ? 'mm-active' : '' }}">
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fas fa-clipboard-list"></i>
						</div>
						<div class="menu-title">Pakage Manage</div>
					</a>
					<ul class="{{ (request()->is('admin/pakages*') || (request()->is('admin/categories*')) || (request()->is('admin/states*')) || (request()->is('admin/cities*')) || (request()->is('admin/tag*')) || (request()->is('admin/language*')) || (request()->is('admin/types*'))) ? 'mm-show' : '' }}">
						<li class="{{ (request()->is('admin/pakages*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.pakages.index')}}"><i class='bx bx-radio-circle'></i>Pakage</a>
						</li>
						<li class="{{ (request()->is('admin/categories*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.categories.index')}}"><i class='bx bx-radio-circle'></i>Category</a>
						</li>
						<li class="{{ (request()->is('admin/states*')) ? 'mm-active' : '' }}"> <a href="{{ route('admin.states.index') }}"><i class='bx bx-radio-circle'></i>State</a>
						</li>
						<li class="{{ (request()->is('admin/cities*')) ? 'mm-active' : '' }}"> <a href="{{ route('admin.cities.index') }}"><i class='bx bx-radio-circle'></i>City</a>
						</li>
						<li class="{{ (request()->is('admin/tag*')) ? 'mm-active' : '' }}"> <a href="{{ route('admin.tag.index') }}"><i class='bx bx-radio-circle'></i>Tag</a>
						</li>
						<li class="{{ (request()->is('admin/types*')) ? 'mm-active' : '' }}"> <a href="{{ route('admin.types.index') }}"><i class='bx bx-radio-circle'></i>Type</a>
						</li>
						<li class="{{ (request()->is('admin/language*')) ? 'mm-active' : '' }}"> <a href="{{ route('admin.language.index') }}"><i class='bx bx-radio-circle'></i>Language</a>
						</li>
					</ul>
				</li>
				
				<li class="{{ (request()->is('admin/blogs*') || (request()->is('admin/category*')) || (request()->is('admin/tags*'))) ? 'mm-active' : '' }}">
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="fas fa-blog"></i>
						</div>
						<div class="menu-title">Blog Manage</div>
					</a>
					<ul class="{{ (request()->is('admin/blogs*') || (request()->is('admin/category*')) || (request()->is('admin/tags*'))) ? 'mm-show' : '' }}">
						<li class="{{ (request()->is('admin/blogs*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.blogs.index')}}"><i class='bx bx-radio-circle'></i>Blogs</a>
						</li>
						<li class="{{ (request()->is('admin/category*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.category.index')}}"><i class='bx bx-radio-circle'></i>Category</a>
						</li>
						<li class="{{ (request()->is('admin/tags*')) ? 'mm-active' : '' }}"> <a href="{{route('admin.tags.index')}}"><i class='bx bx-radio-circle'></i>Tags</a>
						</li>
					</ul>
				</li> 
				<li class="menu-label">{{ __('Profile Setting') }}</li>
				<li>
					<a href="{{ route('admin.profile.index') }}">
						<div class="parent-icon"><i class="bx bx-user-circle"></i>
						</div>
						<div class="menu-title">{{ __('User Profile') }}</div>
					</a>
				</li>
				<li>
					<a href="{{ route('admin.change.password') }}">
						<div class="parent-icon"><i class="lni lni-unlock"></i>
						</div>
						<div class="menu-title">{{ __('Change Password') }}</div>
					</a>
				</li>
				<li>
					<a href="{{route('admin.logout')}}">
						<div class="parent-icon"><i class="bx bx-log-out-circle"></i>
						</div>
						<div class="menu-title">{{ __('Logout') }}</div>
					</a>
					
				</li> 
				@endif 
			</ul>
			<!--end navigation-->
		</div>