@extends('spark::layouts.app')

@section('scripts')
    <style>
        h1.text-center {margin-top: 0;}
    </style>
    <script>
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

var placeSearch, autocomplete;
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initAutocomplete() {
  // Create the autocomplete object, restricting the search to geographical
  // location types.
  autocomplete = new google.maps.places.Autocomplete(
      (document.getElementById('address')),
      {types: ['geocode']});

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

// [START region_fillform]
function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  var img = document.createElement('img'),
    targetElement = document.getElementById("js-address-img");

  img.classList.add('img-responsive');
  img.setAttribute('src', "//maps.googleapis.com/maps/api/staticmap?center="+ place.formatted_address +"&zoom=13&size=346x150&maptype=roadmap&scale=2&markers="+ place.formatted_address +"&key=AIzaSyB7FyN9T9YarDU7F8ZCEXM0EAh6_2swL9A");

    targetElement.querySelector('.fa-spinner').classList.remove('hidden');
    targetElement.appendChild(img);

    img.onload = function(){
        targetElement.querySelector('.fa-spinner').classList.add('hidden');
    };

  /*
  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }
  */

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
 /*
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
  */
}
// [END region_fillform]

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB7FyN9T9YarDU7F8ZCEXM0EAh6_2swL9A&libraries=places&callback=initAutocomplete"
        async defer></script>

@endsection

@section('content')
<div class="container">
    <h1 class="h3 text-center">Create my shop</h1>
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box__content">
                    <form class="form-horizontal" action="{{ route('shops.store') }}" method="post" enctype="multipart/form-data">

                        {!! csrf_field() !!}

                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-4" for="name">Shop name</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="name" value="{{ old('name') }}" id="name" placeholder="Wonderful shop" required>
                                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-4" for="phone">Shop phone</label>
                            <div class="col-sm-4">
                                <input class="form-control" name="phone" value="{{ old('phone') }}" id="phone" type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" placeholder="+1 665-555-1" required>
                                {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-4" for="email">Shop email</label>
                            <div class="col-sm-4">
                                <input class="form-control" name="email" value="{{ old('email') }}" id="email" type="email" placeholder="wonderful@shop.com" required>
                                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-4" for="address">Shop address</label>
                            <div class="col-sm-4">
                                <input class="form-control" name="address" value="{{ old('address') }}" id="address" type="text" placeholder="1 Quality Street, 99110 Ca" required>
                                {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                                <br>
                                <p class="text-center" id="js-address-img">
                                    <i class="fa fa-spinner fa-spin fa-3x fa-fw hidden"></i>
                                </p>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('contact') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-4" for="contact">Contact name</label>
                            <div class="col-sm-4">
                                <input class="form-control" name="contact" value="{{ old('contact', auth()->user()->name) }}" id="contact" type="text" placeholder="Mister Owner" required>
                                {!! $errors->first('contact', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-4">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection