<x-layout>

  
    @include('partials._filter-dropdown')
    @include('partials.event_list', ['events' => $event])
    
</x-layout>