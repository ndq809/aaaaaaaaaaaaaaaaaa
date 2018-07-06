<div class="gw-sidebar sidebar-cover">
  <div id="gw-sidebar" class="gw-sidebar">
    <div class="nano-content">
      <ul class="gw-nav gw-nav-list">
        <li class="init-un-active"> 
            <a class="btn left-menu-btn"><i class="fa fa-reorder"></i></a>
            <a> <span class="gw-menu-text">MENU QUẢN TRỊ</span> </a> 
        </li>
        @foreach(Session::get('menu')[0] as $key=>$value)
        <li > <a class="menu-title"><i class="{{$value['group_icon']}}"></i> <span class="gw-menu-text">{{$value['screen_group_nm']}}</span></a>
          <ul class="gw-submenu">
            @foreach(Session::get('menu')[1] as $key1=>$value1)
            @if($value['screen_group']==$value1['screen_group'])
            <li> <a href="{{$value1['screen_url']}}">{{$value1['screen_nm']}}</a> </li>
            @endif
            @endforeach
          </ul>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>