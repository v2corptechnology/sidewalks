@extends('spark::layouts.app')

@section('scripts')
    <link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">  
    <link href="//rawgit.com/mistic100/Photo-Sphere-Viewer/master/dist/photo-sphere-viewer.min.css" rel="stylesheet" >
    <script src="//rawgit.com/mrdoob/three.js/dev/build/three.min.js"></script>
    <script src="//rawgit.com/malko/D.js/master/lib/D.min.js"></script>
    <script src="//rawgit.com/mistic100/uEvent/master/uevent.min.js"></script>
    <script src="//rawgit.com/olado/doT/master/doT.min.js"></script>
    <script src="//rawgit.com/mrdoob/three.js/master/examples/js/controls/DeviceOrientationControls.js"></script>
    <script src="//rawgit.com/mistic100/Photo-Sphere-Viewer/master/dist/photo-sphere-viewer.min.js"></script>
    <style>
        .schedules__day:not(:last-child) {
            border-bottom: 1px solid #eaeaea;
        }

        /** EXTRA **/
        .form-inline.pull-right {margin-top: -0.6rem;}
    </style>
@endsection

@section('content')
<div class="container" id="root">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <pano panorama="{{ asset('img/R0010168.jpg') }}"
                      raw-markers="[{&quot;target&quot;:&quot;{{ asset('img/R0010169.jpg') }}&quot;,&quot;id&quot;:5,&quot;shop_id&quot;:&quot;1&quot;,&quot;markable_id&quot;:&quot;1&quot;,&quot;markable_type&quot;:&quot;items&quot;,&quot;created_at&quot;:&quot;2017-02-17 11:09:59&quot;,&quot;updated_at&quot;:&quot;2017-02-17 11:09:59&quot;,&quot;filter&quot;:&quot;Items: 1&quot;,&quot;psv_info&quot;:{&quot;html&quot;:&quot;<i style='color: #FFF' class='fa fa-arrow-circle-up fa-5x'></i>&quot;,&quot;latitude&quot;:0,&quot;longitude&quot;:0},&quot;markable&quot;:{&quot;id&quot;:1,&quot;user_id&quot;:&quot;1&quot;,&quot;shop_id&quot;:&quot;1&quot;,&quot;title&quot;:&quot;Nike Men&#039;s Rosherun Running Shoe.&quot;,&quot;description&quot;:&quot;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.&quot;,&quot;quantity&quot;:&quot;1&quot;,&quot;amount&quot;:51,&quot;symbol&quot;:&quot;$&quot;,&quot;images&quot;:[&quot;w2bVPYs1vz28wzcr.jpg&quot;],&quot;extra&quot;:{&quot;url&quot;:&quot;&quot;},&quot;created_at&quot;:&quot;2017-02-16 14:58:26&quot;,&quot;updated_at&quot;:&quot;2017-02-16 14:58:27&quot;,&quot;deleted_at&quot;:null,&quot;display_url&quot;:&quot;http:\/\/sidewalks.dev\/items\/1&quot;,&quot;src&quot;:&quot;https:\/\/eazkmue.cloudimg.io\/crop\/400x200\/q80.tjpg\/http:\/\/sidewalks.dev\/storage\/items\/originals\/1\/w2bVPYs1vz28wzcr.jpg&quot;,&quot;srcset&quot;:&quot;https:\/\/eazkmue.cloudimg.io\/crop\/800x400\/q80.tjpg\/http:\/\/sidewalks.dev\/storage\/items\/originals\/1\/w2bVPYs1vz28wzcr.jpg 2x&quot;}}]">
                </pano>
            </div>
        </div>
    </div>
</div>
@endsection