@extends('layout.template')
@section('content')
    <!-- main-slider -->
    <ul id="demo1">
        <li>
            <img src="images/Iklan1.png" alt="" />
        </li>
        <li>
            <img src="images/Iklan2.png" alt="" />
        </li>

        <li>
            <img src="images/Iklan3.png
                         " alt="" />
        </li>
    </ul>
    <div class="top-brands">
        <div class="container">
            <h2>Jasa Kami</h2>
            <div class="grid_3 grid_5">
                <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="expeditions"
                            aria-labelledby="expeditions-tab">
                            <div class="agile-tp">
                                <h5>Penawaran Terbaik Minggu Ini
                                </h5>
                            </div>
                            <div class="agile_top_brands_grids">
                                @foreach ($jasa as $key => $value )
                                <div class="col-md-4 top_brand_left">
                                    <div class="hover14 column">
                                        <div class="agile_top_brand_left_grid">
                                            <div class="agile_top_brand_left_grid_pos">
                                                <img src="images/offer.png" alt=" " class="img-responsive" />
                                            </div>
                                            <div class="agile_top_brand_left_grid1">
                                                <figure>
                                                    <div class="snipcart-item block">
                                                        <div class="snipcart-thumb">
                                                            <a href=""><img title=" " alt=" "
                                                                    src="{{asset('storage/thumbnail'.'/'.$value->gambar)}}" width="200px" height="200px" /></a>
                                                            <p>{{$value->namajasa}}</p>
                                                            <div class="stars">
                                                                <i class="fa fa-star blue-star" aria-hidden="true"></i>
                                                            </div>
                                                            <h4>Rp {{number_format($value->hargasetelah)}} <span>Rp {{number_format($value->hargasebelum)}}</span>
                                                            </h4>
                                                        </div>
                                                        <div class="snipcart-details top_brand_home_details">
                                                            <fieldset>
                                                                <a href=""><input type="submit" class="button"
                                                                        value="Lihat Produk" /></a>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                </figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="clearfix"> </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('head.style')
    <link rel="stylesheet" href="{{ asset('css/skdslider.css') }}">
@endpush
@push('foot.script')
    <script src="{{ asset('js/skdslider.min.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('#demo1').skdslider({
                'delay': 5000,
                'animationSpeed': 2000,
                'showNextPrev': true,
                'showPlayButton': true,
                'autoSlide': true,
                'animationType': 'fading'
            });

            jQuery('#responsive').change(function() {
                $('#responsive_wrapper').width(jQuery(this).val());
            });

        });
    </script>
@endpush
