@php use App\Enums\EatingOut\EateryType;use Illuminate\Support\Str; @endphp
@vite('resources/js/app.ts')
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap" rel="stylesheet">

<div class="w-[1200px] h-[630px] bg-gradient-to-b from-primary to-primary-light relative overflow-hidden flex flex-col object-cover">
    <div class="flex-1">
        <div class="flex flex-col justify-center space-x-6 items-center z-20 w-full p-6 relative">
            <img src="{{ asset('images/logo.svg') }}" class="w-60"/>
            <span class="font-coeliac text-3xl text-center">
                Coeliac Sanctuary<br/>Gluten Free Blog by Alison Peters
            </span>
        </div>
    </div>

    <div class="border-t-4 border-secondary">
        <span class="font-coeliac text-3xl text-center block w-full mt-6">
            Whats new on Coeliac Sanctuary
        </span>

        <div class="grid gap-4 font-sans p-6 z-20 grid-cols-4">
            @foreach($items as $item)
                <div class="flex flex-col space-y-2">
                    <img class="rounded-lg" src="{{ $item->main_image }}" />

                    <span class=" text-center text-lg font-semibold">{{ $item->title }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>