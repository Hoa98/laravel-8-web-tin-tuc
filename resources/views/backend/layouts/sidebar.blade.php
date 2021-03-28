<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('homepage')}}" class="brand-link">
      <img src="{{asset('images/core-img/logo.png')}}"
           alt="The News Page logo" title="The News Page"
           style="opacity: 0.8; width: 90%;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset(Auth::user()->avatar)}}" class="img-circle elevation-2" width="30" height="30" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               @foreach ($menus as $item)
               @if(!$item['hasChild'])
               <li class="nav-item has-treeview menu-open">
                 <a href="{{$item['url']}}" class="nav-link">
                   <i class="{{$item['icon']}}"></i>
                   <p>{{$item['text']}}</p>
                 </a>
               </li>
               @else
               <li class="nav-item has-treeview">
                 <a href="javascript:;" class="nav-link">
                   <i class="{{$item['icon']}}"></i>
                   <p>
                     {{$item['text']}}
                     <i class="fas fa-angle-left right"></i>
                   </p>
                 </a>
                 <ul class="nav nav-treeview">
                   @foreach ($item['childs'] as $child)
                   <li class="nav-item">
                     <a href="{{$child['url']}}" class="nav-link">
                       <i class="far fa-circle nav-icon"></i>
                       <p>{{$child['text']}}</p>
                     </a>
                   </li>
                   @endforeach
                 </ul>
               </li>
               @endif
           @endforeach
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
