<!DOCTYPE html>
<html lang="en">
    @include('admin.part.head')

    <body>
        <div class="wrapper">
            <div class="padding-global">
                <div class="container-large">
                    <div class="padding-section-small">
                        <div class="container_dashboard">
                            @include('admin.part.side-bar')
                            <div class="container_analyst">
                                <div class="staticstic">
                                    <div class="analyst">
                                        <div class="new-analysts">
                                            <div class="new-things">
                                                <div class="text_analyst">new-order</div>
                                                <div class="number">63</div>
                                            </div>
                                            <div class="new-things">
                                                <div class="text_analyst">new-comment</div>
                                                <div class="number">3</div>
                                            </div>
                                            <div class="new-things">
                                                <div class="text_analyst">new-user</div>
                                                <div class="number">600</div>
                                            </div>
                                        </div>
                                        <div class="money-analysts">
                                            <div class="new-things">
                                                <div class="text_analyst">revennue</div>
                                                <div class="number">
                                                    6300
                                                </div>
                                            </div>
                                            <div class="new-things">
                                                <div class="text_analyst">profit</div>
                                                <div class="number">40000</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="div black"></div>
                                    <div class="store">
                                        <div class="new-things">
                                            <div class="text_analyst">new-order</div>
                                            <div class="number">63</div>
                                        </div>
                                        <div class="row">
                                            <div class="column992 column ">
                                                <div class="card-chart">
                                                    <h4 class="app-card-title">Bar Chart Example</h4>
                                                    <!--app-card-header-->
                                                    <div class="app-card-body p-3 p-lg-4">
                                                        <div class="mb-3 d-flex">
                                                            <select class="form-select form-select-sm ms-auto d-inline-flex w-auto">
                                                                <option value="1" selected>This week</option>
                                                                <option value="2">Today</option>
                                                                <option value="3">This Month</option>
                                                                <option value="3">This Year</option>
                                                            </select>
                                                        </div>
                                                        <div class="chart-container">
                                                            <canvas id="canvas-barchart"></canvas>
                                                        </div>
                                                    </div><!--//app-card-body-->
                                                </div>
                                            </div><!--//app-card-->
                                            <div class="column992 column ">
                                                <div class="card-chart">
                                                        <h4 class="app-card-title">Bar Chart Example</h4>
                                                    <!--app-card-header-->
                                                    <div class="app-card-body p-3 p-lg-4">
                                                        <div class="mb-3 d-flex">
                                                            <select class="form-select form-select-sm ms-auto d-inline-flex w-auto">
                                                                <option value="1" selected>This week</option>
                                                                <option value="2">Today</option>
                                                                <option value="3">This Month</option>
                                                                <option value="3">This Year</option>
                                                            </select>
                                                        </div>
                                                        <div class="chart-container">
                                                            <canvas id="canvas-linechart"></canvas>
                                                        </div>
                                                    </div><!--//app-card-body-->
                                                </div>
                                            </div><!--//app-card-->
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>