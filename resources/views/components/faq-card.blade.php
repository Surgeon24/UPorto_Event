@props(['faq'])

<x-card>
    <div class="flex">
        <img
            class="hidden w-48 mr-6 md:block"
            src="images/no-image.png"alt="" />
        <div>
            <h3 class="text-2xl">
                <a href="/faq/{{$faq->id}}">{{$faq->Q}}</a>
            </h3>
            <div class="text-xl font-bold mb-4">{{$faq->A}}</div>
        </div>
    </div>
</x-card>