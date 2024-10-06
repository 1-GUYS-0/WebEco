<!DOCTYPE html>
<html lang="en">
    @include('customer.preview-page.partials.header')

    <body>
        @include('customer.preview-page.partials.nav-bar')
        <div class="wrapper">
            <div class="padding-global discolumn">
                <div class="container-large discolumn">
                    <div class="padding-section-small discolumn">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @include('customer.preview-page.partials.footer')
    </body>

</html>