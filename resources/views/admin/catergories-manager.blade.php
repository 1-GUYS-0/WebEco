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
                                    <p class="body-bold">Add Catergories</p>
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
                                            <a class="light-text" href="{{ route('caters.add-category') }}"> Add new catergory</a>
                                        </button>
                                    </div>
                                </div> <!-- thanh search-->
                                <table >
                                    <thead >
                                        <tr >
                                            <th >ID</th>
                                            <th >Tên danh mục</th>
                                            <th >Tên danh mục cha</th>
                                            <th >Chi tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <tr >
                                            <td >23</td>
                                            <td >
                                                <div class="table-cell-block">
                                                    <img class="cards-111-image" src="{{ asset('backend/asset/dashboard/cards_image.png')}}" />
                                                </div>
                                            </td>
                                            <td >White poision bottle</td>
                                            <td >
                                                <a href=""> Chi tiết</a>
                                            </td>
                                        </tr>
                                        <tr >
                                            <td >23</td>
                                            <td >
                                                <div class="table-cell-block">
                                                    <img class="cards-111-image" src="{{ asset('backend/asset/dashboard/cards_image.png')}}" />
                                                </div>
                                            </td>
                                            <td >White poision bottle</td>
                                            <td >
                                                <a href=""> Chi tiết</a>
                                            </td>
                                        </tr>
                                        <tr >
                                            <td >23</td>
                                            <td >
                                                <div class="table-cell-block">
                                                    <img class="cards-111-image" src="{{ asset('backend/asset/dashboard/cards_image.png')}}" />
                                                </div>
                                            </td>
                                            <td >White poision bottle</td>
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