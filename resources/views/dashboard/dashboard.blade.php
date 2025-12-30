{{-- @include('dashboard.header') --}}


@extends('dashboard.header')

@section('content')


    <style>
        .custom-countdown {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .custom-countdown .num {
            display: block !important;
            font-size: 48px;
            font-weight: bold;
            color: #ff3b3b;
        }

        .custom-countdown .label {
            margin-top: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #555;
            letter-spacing: 1px;
        }
    </style>
    <!-- SLIDER -->
    <div class="rev_slider_wrapper fullwidthbanner-container">
        <div id="rev-slider2" class="rev_slider fullwidthabanner">
            <ul>

                <!-- Slide 1 -->
                @foreach($sliders as $slide)
                    <li data-transition="random">

                        <!-- Main Image -->
                        <img src="{{ asset('storage/' . $slide->sliderimage) }}">

                        <!-- If heading exists -->
                        @if($slide->sliderheading)
                            <div class="tp-caption tp-resizeme text-6e6 font-weight-500 letter-spacing-08"
                                data-x="['left','left','left','center']" data-hoffset="['7','7','7','0']"
                                data-y="['middle','middle','middle','middle']" data-voffset="['-122','-122','-122','-122']"
                                data-fontsize="['18','18','18','18']" data-lineheight="['36','36','36','36']" data-width="full"
                                data-height="none" data-whitespace="normal" data-transform_idle="o:1;"
                                data-transform_in="y:[100%];s:2000;e:Power4.easeInOut;"
                                data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];"
                                data-mask_out="x:inherit;y:inherit;" data-start="700" style="color: {{ $slide->headingcolor }}">
                                {{ $slide->sliderheading }}
                            </div>
                        @endif

                        <!-- If sub heading exists -->
                        @if($slide->slidersubheading)
                            <div class="tp-caption tp-resizeme text-333 font-weight-500 letter-spacing-7"
                                data-x="['left','left','left','center']" data-hoffset="['7','7','7','0']"
                                data-y="['middle','middle','middle','middle']" data-voffset="['-62','-62','-62','-62']"
                                data-fontsize="['34','34','34','24']" data-lineheight="['80','80','80','50']" data-width="full"
                                data-height="none" data-whitespace="normal" data-transform_idle="o:1;"
                                data-transform_in="y:[100%];s:2000;e:Power4.easeInOut;"
                                data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];"
                                data-mask_out="x:inherit;y:inherit;" data-start="1000" style="color: {{ $slide->subheadingcolor }}">
                                {{ $slide->slidersubheading }}
                            </div>
                        @endif

                        <!-- If description exists -->
                        @if($slide->sliderdescription)
                            <div class="tp-caption tp-resizeme text-6e6 font-weight-300" data-x="['left','left','left','center']"
                                data-hoffset="['7','7','7','0']" data-y="['middle','middle','middle','middle']"
                                data-voffset="['3','3','3','3']" data-fontsize="['20','20','20','20']"
                                data-lineheight="['48','48','48','48']" data-width="full" data-height="none"
                                data-whitespace="normal" data-transform_idle="o:1;"
                                data-transform_in="y:[100%];s:2000;e:Power4.easeInOut;"
                                data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];"
                                data-mask_out="x:inherit;y:inherit;" data-start="1000"
                                style="color: {{ $slide->descriptioncolor }}">
                                {{ $slide->sliderdescription }}
                            </div>
                        @endif

                        <!-- If button text exists -->
                        @if($slide->buttontext)
                            <div class="tp-caption" data-x="['left','left','left','center']" data-hoffset="['7','7','7','0']"
                                data-y="['middle','middle','middle','middle']" data-voffset="['72','72','72','72']"
                                data-width="full" data-height="none" data-whitespace="normal" data-transform_idle="o:1;"
                                data-transform_in="y:[100%];s:2000;e:Power4.easeInOut;"
                                data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;" data-mask_in="x:0px;y:[100%];"
                                data-mask_out="x:inherit;y:inherit;" data-start="1000">

                                <a href="{{ $slide->buttonlink ?? '#' }}" class="themesflat-button has-padding-36 has-shadow"
                                    style="background-color: {{ $slide->buttonbgcolor }}">
                                    <span>{{ $slide->buttontext }}</span>
                                </a>

                            </div>
                        @endif

                    </li>
                @endforeach

                <!-- /End Slide 1 -->

            </ul>
        </div>
    </div>
    <!-- END SLIDER -->

    <!-- IMAGE BOX -->
    <section class="flat-row row-image-box">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="wrap-carousel-box">
                        <div class="flat-image-box flat-carousel-box has-arrows arrow-center bg-transparent offset-62 offset-v-24 style-1 data-effect div-h22 clearfix"
                            data-auto="true" data-column="3" data-column2="2" data-column3="1" data-gap="30">

                            <div class="owl-carousel owl-theme">

                                @foreach ($imageboxs as $imagebox)
                                    <div class="item data-effect-item">
                                        <div class="inner">
                                            <div class="thumb">

                                                <!-- DYNAMIC IMAGE -->
                                                <img src="{{ asset('storage/' . $imagebox->image) }}"
                                                    alt="{{ $imagebox->imageboxtitle }}">

                                                <!-- DYNAMIC TITLE -->
                                                <div class="elm-btn">
                                                    <a href="#" class="themesflat-button bg-white width-150">
                                                        {{ $imagebox->imageboxtitle }}
                                                    </a>
                                                </div>

                                                <div class="overlay-effect bg-color-1"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div> <!-- /.owl-carousel  -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- END IMAGE BOX -->

    <!-- PRODUCT -->

    <!-- PRODUCT -->
    @php use Illuminate\Support\Str; @endphp

    <section class="flat-row row-product-project shop-collection">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="title-section margin-bottom-41">
                        <h2 class="title">Shop Collection</h2>
                    </div>

                    @php
                        // Get ONLY main categories (those without parent)
                        $mainCategories = $allcategories->filter(function ($item) {
                            return $item->parentCategory === null || trim($item->parentCategory) === "";
                        })->values();
                    @endphp

                    <!-- SIMPLE CATEGORY MENU (NO DROPDOWN) -->
                    <ul class="flat-filter style-1 text-center max-width-682 clearfix category-dropdown">
                        @foreach ($mainCategories as $category)
                            <li>
                                <a href="#" class="category-filter" data-filter="{{ Str::slug($category->categoryTitle) }}">
                                    {{ $category->categoryTitle }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- PRODUCT GRID -->
                    <div class="divider h40"></div>
                    <div class="product-content product-fourcolumn clearfix">
                        <ul class="product style2 clearfix">

                            @foreach ($allproducts as $products)

                                @php
                                    // Find category row by matching the title stored in products.category
                                    $cat = $allcategories->firstWhere('categoryTitle', $products->category);

                                    if ($cat && $cat->parentCategory) {
                                        // If subcategory → use parent category TITLE
                                        $mainCat = $cat->parentCategory;
                                    } else {
                                        // Already a main category
                                        $mainCat = $products->category;
                                    }

                                    $catSlug = Str::slug($mainCat);
                                @endphp

                                <li class="product-item" data-category="{{ $catSlug }}">

                                    <div class="product-thumb clearfix">
                                        <a href="#">
                                            <img src="{{ asset('storage/' . $products->image) }}" alt="image"
                                                style="width:100%; height:200px; object-fit:cover;">
                                        </a>
                                        <span class="new">{{  $products->badge }}</span>

                                    </div>

                                    <div class="product-info clearfix">
                                        <span class="product-title">{{ $products->productname }}</span>

                                        <div class="price">
                                            @if ($products->saleprice && $products->saleprice < $products->price)
                                                <del>
                                                    <span class="regular">${{ $products->price }}</span>
                                                </del>
                                                <ins>
                                                    <span class="amount" style="color:#ff0000;">${{ $products->saleprice }}</span>
                                                </ins>
                                            @else
                                                <ins>
                                                    <span class="amount">${{ $products->price }}</span>
                                                </ins>
                                            @endif
                                        </div>

                                        <ul class="flat-color-list width-14">
                                            <li><a href="#" class="red"></a></li>
                                            <li><a href="#" class="blue"></a></li>
                                            <li><a href="#" class="black"></a></li>
                                        </ul>
                                    </div>

                                    <div class="add-to-cart text-center">
                                        <a href="#">ADD TO CART</a>
                                    </div>

                                    <a href="#" class="like"><i class="fa fa-heart-o"></i></a>
                                </li>

                            @endforeach

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const categoryLinks = document.querySelectorAll(".category-filter");
            const products = document.querySelectorAll(".product-item");

            // DEFAULT: SHOW FIRST CATEGORY
            if (categoryLinks.length > 0) {
                let defaultCategory = categoryLinks[0].getAttribute("data-filter");

                products.forEach(product => {
                    let productCategory = product.getAttribute("data-category");

                    product.style.display =
                        productCategory === defaultCategory ? "block" : "none";
                });
            }

            // ON CLICK
            categoryLinks.forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();

                    let category = this.getAttribute("data-filter");

                    products.forEach(product => {
                        let productCategory = product.getAttribute("data-category");

                        product.style.display =
                            productCategory === category ? "block" : "none";
                    });
                });
            });

        });
    </script>


    <style>
        /* SPACE BETWEEN PRODUCT CARDS */
        .product-content.product-fourcolumn ul.product.style2>li.product-item {
            padding: 0 15px !important;
            /* horizontal spacing */
            margin-bottom: 25px !important;
            /* vertical spacing */
            box-sizing: border-box !important;
        }
    </style>

    <!-- END PRODUCT -->



    <!-- COUNTDOWN -->
    <div class="flat-row row-countdown no-padding">
        <div class="container-fluid">
            <div class="row equal sm-equal-auto">

                <!-- LEFT SIDE IMAGE (col-6) -->
                <div class="col-md-6 p-0">
                    @if ($countdowns && $countdowns->image)
                        <img src="{{ asset('storage/' . $countdowns->image) }}" alt="Countdown Image"
                            style="width:100%; height:530px; object-fit:cover;">
                    @else
                        <img src="{{ asset('default/countdown-placeholder.jpg') }}" alt="No Countdown Image"
                            style="width:100%; height:500px; object-fit:cover;">
                    @endif
                </div>

                <!-- RIGHT SIDE COUNTDOWN (col-6) -->
                <div class="col-md-6 bg-section bg-color-f5f">
                    <div class="flat-content-box clearfix" data-margin="0 0 0 8px" data-mobilemargin="0 0 0 0">
                        <div class="flat-countdown-wrap text-center">
                            <div class="inner">
                                <div class="divider h120 clearfix"></div>

                                <h2 class="heading font-size-40 line-height-48">
                                    {{ $countdowns->title ?? 'Deal Of The Week' }}
                                </h2>

                                <p class="desc font-size-18 font-weight-400 line-height-48">
                                    {{ $countdowns->subtitle ?? 'Special Discount Limited Time Only' }}
                                </p>

                                <div class="divider h42 clearfix"></div>

                                <div class="wrap-countdown no-margin-bottom">
                                    <div class="custom-countdown" id="mainCountdown"
                                        data-end="{{ \Carbon\Carbon::parse(time: $countdowns?->end_datetime)->toIso8601String() }}">

                                        <div class="countdown-box">
                                            <span class="num" id="days">00</span>
                                            <span class="label">DAYS</span>
                                        </div>

                                        <div class="countdown-box">
                                            <span class="num" id="hours">00</span>
                                            <span class="label">HOURS</span>
                                        </div>

                                        <div class="countdown-box">
                                            <span class="num" id="minutes">00</span>
                                            <span class="label">MINUTES</span>
                                        </div>

                                        <div class="countdown-box">
                                            <span class="num" id="seconds">00</span>
                                            <span class="label">SECONDS</span>
                                        </div>

                                    </div>
                                </div>

                                <div class="divider h30 clearfix"></div>
                                <a href="#" class="grab-btn" style="
                                                                display:inline-block;
                                                                background:#ff4d4d;
                                                                color:#fff;
                                                                padding:12px 28px;
                                                                font-size:18px;
                                                                font-weight:600;
                                                                border-radius:6px;
                                                                text-decoration:none;
                                                                transition:0.3s;
                                                            ">
                                    Grab It
                                </a>

                                <div class="divider h120 clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>

    <style>
        .grab-btn:hover {
            background: #e63939;
            color: #fff;


        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const container = document.getElementById("mainCountdown");
            if (!container) return;

            const endTime = container.getAttribute("data-end");

            const daysEl = document.getElementById("days");
            const hoursEl = document.getElementById("hours");
            const minutesEl = document.getElementById("minutes");
            const secondsEl = document.getElementById("seconds");
            console.log("End Time:", endTime);
            console.log("Parsed Date:", new Date(endTime));

            function updateTimer() {
                const now = new Date().getTime();
                const end = new Date(endTime).getTime();
                const diff = end - now;

                if (diff <= 0) {
                    daysEl.textContent = "00";
                    hoursEl.textContent = "00";
                    minutesEl.textContent = "00";
                    secondsEl.textContent = "00";
                    return;
                }

                const d = Math.floor(diff / (1000 * 60 * 60 * 24));
                const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((diff % (1000 * 60)) / 1000);

                daysEl.textContent = d.toString().padStart(2, "0");
                hoursEl.textContent = h.toString().padStart(2, "0");
                minutesEl.textContent = m.toString().padStart(2, "0");
                secondsEl.textContent = s.toString().padStart(2, "0");
            }

            updateTimer();
            setInterval(updateTimer, 1000);
        });
    </script>


    <!-- END COUNTDOWN -->

    <!-- SALE PRODUCT -->

    <section class="flat-row row-best-sale">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="title-section margin-bottom-43">
                        <h2 class="title">Best Sale</h2>
                    </div>

                    @php
                        // Get ONLY sale products
                        $saleProducts = $allproducts->filter(function ($item) {
                            return strtolower(trim($item->badge)) === "sale";
                        });

                        // Collect categories belonging to sale items
                        $saleCategories = $saleProducts->map(function ($p) {
                            return $p->category;
                        })->unique();

                        // Find main categories for those sale products
                        $mainCategories = $allcategories->filter(function ($cat) use ($saleCategories) {
                            return $saleCategories->contains($cat->categoryTitle);
                        });
                    @endphp


                    <!-- CATEGORY FILTER BOX (same style as file 1) -->
                    <ul class="flat-filter style-1 text-center max-width-682 clearfix category-dropdown">
                        @foreach ($mainCategories as $category)
                            <li>
                                <a href="#" class="sale-category-filter"
                                    data-filter="{{ Str::slug($category->categoryTitle) }}">
                                    {{ $category->categoryTitle }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="divider h40"></div>


                    <!-- SALE PRODUCT GRID -->
                    <div class="product-content product-fivecolumn clearfix">
                        <ul class="product style3">

                            @foreach($saleProducts as $product)

                                @php
                                    $catSlug = Str::slug($product->category);
                                @endphp

                                <li class="product-item" data-category="{{ $catSlug }}">
                                    <div class="product-thumb clearfix">
                                        <a href="#">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="image">
                                        </a>
                                        <span class="new sale">Sale</span>
                                    </div>

                                    <div class="product-info clearfix">
                                        <span class="product-title">{{ $product->productname }}</span>

                                        <div class="price">
                                            <del>
                                                <span class="regular">${{ $product->price }}</span>
                                            </del>
                                            <ins>
                                                <span class="amount" style="color:#ff0000;">
                                                    ${{ $product->saleprice }}
                                                </span>
                                            </ins>
                                        </div>
                                    </div>

                                    <div class="add-to-cart text-center">
                                        <a href="#">ADD TO CART</a>
                                    </div>

                                    <a href="#" class="like"><i class="fa fa-heart-o"></i></a>
                                </li>

                            @endforeach

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <!-- SAME JS FILTERING FROM FILE 1 -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const categoryLinks = document.querySelectorAll(".sale-category-filter");
            const products = document.querySelectorAll(".product-item");

            // DEFAULT: SHOW FIRST SALE CATEGORY
            if (categoryLinks.length > 0) {
                let defaultCategory = categoryLinks[0].getAttribute("data-filter");

                products.forEach(product => {
                    let productCategory = product.getAttribute("data-category");

                    product.style.display =
                        productCategory === defaultCategory ? "block" : "none";
                });
            }

            // ON CLICK FILTER
            categoryLinks.forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();

                    let category = this.getAttribute("data-filter");

                    products.forEach(product => {
                        let productCategory = product.getAttribute("data-category");

                        product.style.display =
                            productCategory === category ? "block" : "none";
                    });
                });
            });

        });
    </script>

    <style>
        /* spacing between cards */
        .product-content.product-fivecolumn ul.product.style3>li.product-item {
            padding: 0 15px !important;
            margin-bottom: 25px !important;
            box-sizing: border-box !important;
        }
    </style>

    <!-- END SALE PRODUCT -->

    <!-- ICON BOX -->
    <section class="flat-row row-icon-box style-1 bg-section bg-color-f5f">
        <div class="container">
            <div class="row">

                @foreach ($infocards as $infocard)

                    <div class="col-md-3">
                        <div class="flat-icon-box icon-left w55 circle bg-white style-1 clearfix">
                            <div class="inner no-margin flat-content-box">

                                <div class="icon-wrap">

                                    {{-- IMAGE CHECK --}}
                                    @if ($infocard->image)
                                        <img src="{{ asset('storage/' . $infocard->image) }}" alt="{{ $infocard->title }}"
                                            style="width:40px; height:40px; object-fit:contain;">

                                        {{-- ICON CHECK --}}
                                    @elseif ($infocard->icon)
                                        <img src="{{ asset('storage/' . $infocard->icon) }}" alt="{{ $infocard->title }}"
                                            style="width:40px; height:40px; object-fit:contain;">

                                        {{-- DEFAULT ICON (optional fallback) --}}
                                    @else
                                        <i class="fa fa-info-circle"></i>
                                    @endif

                                </div>

                                <div class="text-wrap">
                                    <h5 class="heading letter-spacing--1">
                                        {{ $infocard->title }}
                                    </h5>

                                    <p class="desc">
                                        {{ $infocard->description }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                @endforeach



            </div>
        </div>
    </section>
    <!-- END ICON BOX -->

    <!-- NEW LATEST -->
    <section class="flat-row row-new-latest style-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-section margin-bottom-51">
                        <h2 class="title">New Latest</h2>
                    </div>
                    <div class="new-latest-wrap">
                        <div class="flat-new-latest post-wrap flat-carousel-box style4 data-effect clearfix"
                            data-auto="false" data-column="3" data-column2="2" data-column3="1" data-gap="30">
                            <div class="owl-carousel owl-theme">
                                @foreach ($blogs as $blog)

                                    <article class="post clearfix">
                                        <div class="featured-post data-effect-item">
                                            <img src="{{ asset('storage/' . $blog->image) }}" alt="image">
                                            <div class="overlay-effect bg-overlay-black opacity02"></div>
                                        </div>
                                        <div class="content-post">
                                            <ul class="meta-post">
                                                <li class="date">
                                                    {{ $blog->date }}
                                                </li>
                                                <li class="author">
                                                    <a href="#"> By Admin</a>
                                                </li>
                                            </ul><!-- /.meta-post -->
                                            <div class="title-post">
                                                <h2><a href="blog-detail.html"> {{ $blog->title}}</a></h2>
                                            </div><!-- /.title-post -->
                                            <div class="entry-post">
                                                <div class="more-link">
                                                    <a href="blog-detail.html">Continue Reading </a>
                                                </div>
                                            </div>
                                        </div><!-- /.content-post -->
                                    </article><!-- /.post -->

                                @endforeach

                            </div><!-- /.owl-carousel -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- END NEW LATEST -->



    <section class="flat-row mail-chimp">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="text">
                        <h3>Sign up for Send Newsletter</h3>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="subscribe clearfix">
                        <form action="{{ route('mail.store') }}" method="post" id="subscribe-form">
                            @csrf
                            <div class="subscribe-content">
                                <div class="input">
                                    <input type="email" name="email" placeholder="Your Email" required>
                                </div>
                                <div class="button">
                                    <button type="submit">SUBSCRIBE</button>
                                </div>
                            </div>
                        </form>

                        <ul class="flat-social">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google"></i></a></li>
                            <li><a href="#"><i class="fa fa-behance"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul><!-- /.flat-social -->
                    </div><!-- /.subscribe -->
                </div>
            </div>
        </div>
    </section><!-- /.mail-chimp -->



@endsection
