<option>{{ __('Choose City') }}</option>
@if(!empty($cities))
  @foreach($cities as $key => $row)
    <option value="{{ $row->id }}">{{ $row->name }}</option>
  @endforeach
@endif