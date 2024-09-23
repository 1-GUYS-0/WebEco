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
                                <p class="body-bold">Products manager</p>
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
                                <div class="new-catergory">
                                    <button type="button" class="button">
                                    <a class="light-text" href="{{ route('products.view_add-product') }}"> Add new catergory</a>
                                    </button>
                                </div>
                            </div> <!-- thanh search-->
                            <div class=" container-table">
                                <table >
                                    <thead >
                                        <tr >
                                            <th >ID</th>
                                            <th >Tên sản phẩm</th>
                                            <th >Ảnh sản phẩm</th>
                                            <th >Tên danh mục sản phẩm</th>
                                            <th >Giá ban đầu</th>
                                            <th >Giá bán</th>
                                            <th >Tồn kho</th>
                                            <th >Chi tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <tr >
                                            <td >23</td>
                                            <td >
                                                <div class="table-cell-block">
                                                    <img class="cards-111-image" src="../src/dasboard/cards_image.png" />
                                                </div>
                                            </td>
                                            <td >White poision bottle</td>
                                            <td> Tảy trang </td>
                                            <td >20.000</td>
                                            <td >16.000</td>
                                            <td >340</td>
                                            <td >
                                                <a href=""> Chi tiết</a>
                                            </td>
                                        </tr>
                                        <tr >
                                            <td >23</td>
                                            <td >
                                                <div class="table-cell-block">
                                                    <img class="cards-111-image" src="../src/dasboard/cards_image.png" />
                                                </div>
                                            </td>
                                            <td >White poision bottle</td>
                                            <td> Tảy trang </td>
                                            <td >20.000</td>
                                            <td >16.000</td>
                                            <td >340</td>
                                            <td >
                                                <a href=""> Chi tiết</a>
                                            </td>
                                        </tr>
                                        <tr >
                                            <td >23</td>
                                            <td >
                                                <div class="table-cell-block">
                                                    <img class="cards-111-image" src="../src/dasboard/cards_image.png" />
                                                </div>
                                            </td>
                                            <td >White poision bottle</td>
                                            <td> Tảy trang </td>
                                            <td >20.000</td>
                                            <td >16.000</td>
                                            <td >340</td>
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