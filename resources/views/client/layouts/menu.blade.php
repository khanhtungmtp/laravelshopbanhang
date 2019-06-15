<div class="navbar-inner">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="agileits-navi_search">
                <form action="#" method="post">

                    <select id="agileinfo-nav_search" name="agileinfo_search" class="border" required="">
                        <option value="">All Categories</option>
                        @foreach ($category as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>

                </form>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto text-center mr-xl-5">
                    <li class="nav-item active mr-lg-2 mb-lg-0 mb-2">
                        <a class="nav-link" href="index.html">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    @foreach ($category as $cat)
                        <li class="nav-item dropdown mr-lg-2 mb-lg-0 mb-2">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ $cat->name }}
                            </a>
                            @if (count($cat->productType) > 0)
                                @foreach ($cat->productType as $productType)
                                    <div class="dropdown-menu">
                                        <a href="#" class="dropdown-item">{{ $productType->name }}</a>
                                    </div>
                                @endforeach
                            @endif
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact Us</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
