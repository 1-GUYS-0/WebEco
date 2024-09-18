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
                                    <p class="body-bold">Slide manager</p>
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
                                        <button type="button" onclick="alert('Xin chào!')" class="button">
                                            <div class="light-text"> Add new slide</div>
                                        </button>
                                    </div>
                                </div> <!-- thanh search-->
                                <table >
                                    <thead >
                                        <tr >
                                            <th >ID</th>
                                            <th >Ảnh slide</th>
                                            <th >mô tả</th>
                                            <th >Thứ tự xuất hiện</th>
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
                                            <td >Chương trình các sản phẩm về da tốt nhất</td>
                                            <td> 1 </td>
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
                                            <td >Chương trình các sản phẩm giảm 50%</td>
                                            <td> 2 </td>
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
                                            <td >Chương trình sản phẩm mùa hè sôi động</td>
                                            <td> 3 </td>
                                            <td >
                                                <a href=""> Chi tiết</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table><!--bảng data-->
                                <div class="div black"></div>
                            </div> <!--container_cater-manager -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>