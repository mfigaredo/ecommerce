@props(['items', 'noContent', 'idRef', 'displayRef', 'prompt', 'id'])

@if (count($items) || empty($noContent))
  <select {{ $attributes->merge([])}}>

    @if (!empty($prompt))
      <option value="" selected disabled>{{$prompt}}</option>
    @endif

    @foreach ($items as $item)
      <option value="{{ $item[$idRef] }}" {{ (isset($id) && $item[$idRef] == $id) ? 'selected' : '' }} >{{ __($item[$displayRef]) }}</option>
    @endforeach
  </select>
    
@elseif ( !empty($noContent) )
  <p>{{ $noContent }}</p>
@endif
