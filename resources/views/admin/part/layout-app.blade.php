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
                        @yield('content')
                        <div class="div black"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>