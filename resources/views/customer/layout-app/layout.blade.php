<!DOCTYPE html>
<html lang="en">
    @include('customer.partials.header')

    <body>
        <div class="wrapper">
            <div class="padding-global discolumn">
                <div class="container-large discolumn">
                    <div class="padding-section-small discolumn">
                        @include('customer.partials.nav-bar')
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>
    @include('customer.partials.footer')

</html>