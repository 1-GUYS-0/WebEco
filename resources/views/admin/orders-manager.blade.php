<!DOCTYPE html>
<html lang="en">
    @include('admin.part.head')

    <body>
        <div class="wrapper">
            <div class="padding-global">
                <div class="container-large">
                    <div class="padding-section-small">
                        <div class="container_add-productS">
                            @include('admin.part.side-bar')
                            <div class="container_cater-manager">
                                <div class="title_feature">
                                    <p class="body-bold">Orders manager</p>
                                </div> <!--tittle của chức năng-->
                                <div class="search-box">
                                    <div class="search-bar">
                                        <div>
                                            <span class="material-symbols-outlined">search</span>
                                        </div>
                                        <form class="input" for="searchCatergpry">
                                            <input type="text" id="searchCatergpry" class="input_lable" placeholder="Search for catergory">
                                        </form> 
                                    </div>
                                </div> <!-- thanh search-->
                                <div class=" container-table">
                                    <table >
                                        <thead >
                                            <tr >
                                                <th >ID</th>
                                                <th >Tên khách hàng</th>
                                                <th >Ngày đặt đơn</th>
                                                <th >Trạng thái đơn</th>
                                                <th >Tổng số tiền</th>
                                                <th >Phương thức thanh toán</th>
                                                <th >Số lượng sản phẩm</th>
                                                <th >Chi tiết</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <tr >
                                                <td >23</td>
                                                <td > Nguyễn Văn A</td>
                                                <td >17/05/2024</td>
                                                <td> Chưa xác nhận </td>
                                                <td >20.000</td>
                                                <td >Giao hàng tận nhà</td>
                                                <td >3</td>
                                                <td >
                                                    <a href=""> Chi tiết</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table><!--bảng data-->
                                </div>
                                <div class="div black"></div>
                            </div> <!--container_cater-manager -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>