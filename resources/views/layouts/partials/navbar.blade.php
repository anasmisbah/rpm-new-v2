@php
use App\Voucher;
use App\DeliveryOrder;
use App\Critic;
$vouchers = Voucher::orderBy('id','desc')->limit(3)->get();
$delivery_darat = DeliveryOrder::where([['status',3],['shipped_via',0]])->orderBy('updated_at','desc')->limit(3)->get();
$delivery_laut = DeliveryOrder::where([['status',3],['shipped_via',1]])->orderBy('updated_at','desc')->limit(3)->get();
$critics = Critic::orderBy('updated_at','desc')->limit(3)->get();
@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        @if (auth()->user()->role_id == 1)
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                {{-- <i class="fa fa-shipping-fast"></i> --}}
                <i class="fa fa-thumbs-up"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @foreach ($critics as $critic)
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{asset('/uploads/'.$critic->delivery_order->sales_order->customer->logo)}}" alt="User Avatar"
                            class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                {{$critic->delivery_order->sales_order->customer->name}} 
                            </h3>
                            <p class="text-sm">{{$critic->critics_suggestion}}</p>
                            <p class="text-sm">{{$critic->service}}</p>
                            <p class="text-sm text-muted">
                                @for ($i = 0; $i < $critic->rating; $i++)
                                <i class="fa fa-star mr-1"></i>
                                @endfor
                            </p>
                            <p class="text-sm text-muted"><i
                                    class="far fa-clock mr-1"></i>{{$critic->created_at->format('d F Y')}}
                                {{$critic->created_at->format('H:i:s')}}</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                @endforeach
                <div class="dropdown-divider"></div>
                <a href="{{route('home.delivery.critic')}}" class="dropdown-item dropdown-footer">Lihat Semua Kritik dan Rating</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                {{-- <i class="fa fa-shipping-fast"></i> --}}
                <i class="ion ion-android-boat"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @foreach ($delivery_laut as $delivery)
                <a href="{{route('deliveryorder.agen.show',$delivery->id)}}" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{asset('/uploads/'.$delivery->driver->avatar)}}" alt="User Avatar"
                            class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                {{$delivery->driver->name}}
                            </h3>
                            <p class="text-sm">Driver Telah Menyelesaikan Pengantaran Delivery Order
                                {{$delivery->sales_order->sales_order_number}}</p>
                            <p class="text-sm text-muted"><i
                                    class="far fa-clock mr-1"></i>{{$delivery->arrival_time->format('d F Y')}}
                                {{$delivery->arrival_time->format('H:i:s')}}</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                @endforeach
                <div class="dropdown-divider"></div>
                <a href="{{route('home.delivery.laut')}}" class="dropdown-item dropdown-footer">Lihat Semua Pengantaran
                    Jalur Laut</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-truck-pickup"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @foreach ($delivery_darat as $delivery)
                <a href="{{route('deliveryorder.agen.show',$delivery->id)}}" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{asset('/uploads/'.$delivery->driver->avatar)}}" alt="User Avatar"
                            class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                {{$delivery->driver->name}}
                            </h3>
                            <p class="text-sm">Driver Telah Menyelesaikan Pengantaran Delivery Order
                                {{$delivery->sales_order->sales_order_number}}</p>
                            <p class="text-sm text-muted"><i
                                    class="far fa-clock mr-1"></i>{{$delivery->arrival_time->format('d F Y')}}
                                {{$delivery->arrival_time->format('H:i:s')}}</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                @endforeach
                <div class="dropdown-divider"></div>
                <a href="{{route('home.delivery.darat')}}" class="dropdown-item dropdown-footer">Lihat Semua Pengantaran
                    Jalur Darat</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @foreach ($vouchers as $voucher)
                <a href="{{route('home.voucher')}}" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{asset('/uploads/'.$voucher->customer->logo)}}" alt="User Avatar"
                            class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                {{$voucher->customer->name}}
                            </h3>
                            <p class="text-sm">Customer telah mengambil promo {{$voucher->promo->name}}...</p>
                            <p class="text-sm text-muted"><i
                                    class="far fa-clock mr-1"></i>{{$voucher->created_at->format('l, d F Y')}}</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                @endforeach
                <div class="dropdown-divider"></div>
                <a href="{{route('home.voucher')}}" class="dropdown-item dropdown-footer">Lihat Semua Pengambilan
                    Promo</a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        @endif

        <li class="nav-item">
            <a class="nav-link" data-slide="true" href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                <i class="fas fa-power-off"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
