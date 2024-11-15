<div>
    <input type="text" class="custom-input" placeholder="{{ $placeholder }}" name="{{$nombre}}" value="{{old($nombre)}}">
    <small class="text-danger fst-italic"> {{$errors->first($nombre)}}</small>
</div>