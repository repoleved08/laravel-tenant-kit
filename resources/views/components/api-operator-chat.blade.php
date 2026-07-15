@if(\App\Support\ApiOperator::visibleOnRequest())
    @include('partials.api-operator-widget')
    @vite(['resources/js/api-operator-widget.js'])
@endif
