<x-layout>
    @include('partials._filter-search')
    @include('partials.event_list', ['events' => $event])

</x-layout>