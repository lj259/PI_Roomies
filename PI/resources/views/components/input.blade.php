
    <!--Esta cosa es para agilizar el estar poniendo los inputs y reducir el codigo-->
    <input type="text" class="form-control mt-2" placeholder="{{ $placeholder }}" name="{{$nombre}}" value="{{old($nombre)}}">
    <small class="text-danger fst-italic mt-1"> {{$errors->first($nombre)}}</small>
