<!DOCTYPE html>
<html lang="en">
@include('admin.part.head')

<body>
    <section class="wrapper">
        <div class="padding-global">
            <div class="container-large">
                <div class="padding-section-small">
                    <div class="container_add-productS">
                        @include('admin.part.side-bar')
                        <div class="container_add-product">
                            <div class="title_feature">
                                <p class="body-bold">Add Products</p>
                            </div>
                            <form class="form_add-product">
                                <div class="wrap_input">
                                    <div class="input" for="nameProduct">
                                        <div class="input_title">fsdsdfds Tên sản phẩm</div>
                                        <input type="text" id="nameProduct" class="input_lable" placeholder="Nhập tên sản phẩm">
                                    </div>
                                    <div class="input" for="priceProduct">
                                        <div class="input_title">Giá sản phẩm</div>
                                        <input type="text" id="priceProduct" class="input_lable" placeholder="Nhập giá sản phẩm">
                                    </div>
                                    <div class="input" for="smellProduct">
                                        <div class="input_title">Mùi hương</div>
                                        <input type="text" id="smellProduct" class="input_lable" placeholder="Nhập mùi hương sản phẩm">
                                    </div>
                                    <div class="input" for="textureProduct">
                                        <div class="input_title">Kết cấu</div>
                                        <input type="text" id="textureProduct" class="input_lable" placeholder="Nhập kết cấu sản phẩm">
                                    </div>
                                    <div class="input" for="ingreMainProduct">
                                        <div class="input_title">Thành phầm chính</div>
                                        <input type="text" id="ingreMainProduct" class="input_lable" placeholder="Nhập thành phần chính">
                                    </div>
                                    <div class="input" for="skinProduct">
                                        <div class="input_title">Loại da</div>
                                        <input type="text" id="skinProduct" class="input_lable" placeholder="Nhập loại da phù hợp">
                                    </div>
                                    <div class="input" for="caterProduct">
                                        <div class="input_title">Danh mục sản phẩm</div>
                                        <input type="text" id="caterProduct" class="input_lable" placeholder="Chọn danh mục sản phẩm">
                                    </div>
                                    <div class="input" for="parentCaterProduct">
                                        <div class="input_title">Danh mục cha</div>
                                        <input type="text" id="parenCaterProduct" class="input_lable" placeholder="Chọn danh mục cha của sản phẩm">
                                    </div>
                                </div>
                                <div class="div"></div>
                                <div class="input" for="detailProduct">
                                    <div class="input_title">Mô tả sản phẩm</div>
                                    <textarea type="text" id="detailProduct" class="input_lable" placeholder="Nhập mô tả sản phẩm"></textarea>
                                </div>
                                <div class="input" for="notelProduct">
                                    <div class="input_title">Lưu ý sản phẩm</div>
                                    <textarea type="text" id="noteProduct" class="input_lable" placeholder="Nhập lưu ý sản phẩm"></textarea>
                                </div>
                                <div class="input" for="detailProduct">
                                    <div class="input_title">Thành phần cụ thể sản phẩm</div>
                                    <textarea type="text" id="detailProduct" class="input_lable" placeholder="Nhập thành phần cụ thể sản phẩm"></textarea>
                                </div>
                                <div class="input">
                                    <div class="input_title">Ảnh của sản phẩm</div>
                                    <div class="list-image">
                                        <div class="image-block">
                                            <img class="cards-image" src="../src/dasboard/cards_image.png" />
                                            <div class="close-icon">
                                                <button class="material-symbols-outlined">close</button>
                                            </div>
                                        </div>
                                        <div class="image-block">
                                            <img class="cards-image" src="../src/dasboard/cards_image.png" />
                                            <div class="close-icon">
                                                <button class="material-symbols-outlined">close</button>
                                            </div>
                                        </div>
                                        <div class="image-block">
                                            <img class="cards-image" src="../src/dasboard/cards_image.png" />
                                            <div class="close-icon">
                                                <button class="material-symbols-outlined">close</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" onclick="alert('Xin chào!')" class="button">
                                        <div class="light-text">Thêm ảnh</div>
                                    </button>
                                </div>
                                <div class="div"></div>
                                <div class="confirm">
                                    <button type="button" onclick="alert('Xin chào!')" class="button">
                                        <div class="light-text">Xác nhận</div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>