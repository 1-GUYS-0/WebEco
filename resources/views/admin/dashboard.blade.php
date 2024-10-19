@extends('admin.part.layout-app')
@section('content')
<div class="container_analyst">
    <div class="staticstic">
        <div class="store">
            <div class="row">
                <div class="column992 column ">
                    <div class="card-chart">
                        <h4 class="app-card-title">Thống kê đơn hàng theo tháng trong năm</h4>
                        <!--app-card-header-->
                        <div class="app-card-body p-3 p-lg-4">
                            <div class="chart-container">
                                <canvas id="canvas-barchart"></canvas>
                            </div>
                        </div><!--//app-card-body-->
                    </div>
                </div><!--//app-card-->
                <div class="column992 column ">
                    <div class="card-chart">
                        <h4 class="app-card-title">Thống kê đơn hàng bán ra theo danh mục sản phẩm</h4>
                        <!--app-card-header-->
                        <div class="app-card-body p-3 p-lg-4">
                            <div class="chart-container">
                                <canvas id="canvas-piechart"></canvas>
                            </div>
                        </div><!--//app-card-body-->
                    </div>
                </div><!--//app-card-->
            </div>
        </div>
        <div class="div black"></div>
        <h1> Thống kê số lượng và doanh thu</h1>
        <div style="background: white;padding:1rem;border-radius: 1rem; max-width:7rem; border:0.2rem solid #000;">
            <select id="nanalystTime">
                <option value="td" selected>Today</option>
                <option value="tw">This week</option>
                <option value="tm">This Month</option>
                <option value="ty">This Year</option>
            </select>
        </div>
        <div class="analyst">
            <div class="new-analysts">
                <div class="new-things">
                    <div class="text_analyst">Đơn hàng mới</div>
                    <div class="number" id="newOrdersCount">{{$newOrdersCount}}</div>
                </div>
                <div class="new-things">
                    <div class="text_analyst">Tổng đơn hàng</div>
                    <div class="number" id="todayOrdersCount">{{$todayOrdersCount}}</div>
                </div>
                <div class="new-things">
                    <div class="text_analyst">Khách hàng mới đăng ký</div>
                    <div class="number" id="newCustomersCount">{{$newCustomersCount}}</div>
                </div>
            </div>
            <div class="money-analysts">
                <div class="new-things">
                    <div class="text_analyst">Doanh thu hiện tại</div>
                    <div class="number" id="todayRevenue">{{ number_format($todayRevenue, 0, ',', '.') }}</div>
                </div>
                <div class="new-things">
                    <div class="text_analyst">Doanh thu tổng</div>
                    <div class="number" id="totalRevenue">{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="div black"></div>
        <h1> Kho hàng</h1>
        <div class="analyst-stock">
            @foreach ($productsStocks as $productsStock)
            <div class="new-things">
                <div class="text_analyst" >ID: {{$productsStock->id}}, <h4>Tên: {{$productsStock->name}}</h4> </div>
                <div class="number">{{$productsStock->stock}}</div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
<script src="{{ asset('backend/js/dashboard.js')}}" defer></script>
<script src="{{ asset('backend/js/index-charts.js')}}" defer></script>