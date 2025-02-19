@php use App\Enums\EatingOut\EateryType;use Illuminate\Support\Str; @endphp
@vite('resources/js/app.ts')
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap" rel="stylesheet">

<div class="w-[1200px] h-[630px] bg-[#D3ECFC] relative overflow-hidden flex flex-col object-cover">
    @unless($eatery->county_id === 1)
    <div class="absolute top-0 right-0 w-[600px] h-[630px]">
        <div
            style='background: url("https://maps.googleapis.com/maps/api/staticmap?center={{ $eatery->lat }},{{ $eatery->lng }}&size=600x630&scale=1&maptype=roadmap&markers=color:red|label:|{{ $eatery->lat }},{{ $eatery->lng }}&style=feature:administrative%7Celement:geometry%7Cvisibility:off&style=feature:administrative%7Celement:labels%7Cvisibility:off&style=feature:landscape%7Ccolor:0xaddaf9%7Clightness:45%7Cvisibility:on&style=feature:poi%7Cvisibility:off&style=feature:road%7Celement:labels.icon%7Cvisibility:off&style=feature:road.highway%7Celement:geometry.fill%7Ccolor:0xdbbc25%7Clightness:60&style=feature:road.highway%7Celement:geometry.stroke%7Ccolor:0xffeb3b%7Cvisibility:off&style=feature:transit%7Cvisibility:off&style=feature:water%7Ccolor:0xaddaf9&key={{ config('services.google.maps.static') }}") no-repeat 50% 100%; background-size: contain;'
            class="w-full h-full object-cover"
        ></div>
    </div>
    @endunless

    <div class="flex-1">
        <div class="flex justify-between z-20 w-full p-6 relative">
            <div class="flex flex-col items-center w-1/2">
                <img src="{{ asset('images/logo.svg') }}"/>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 max-h-[250px]">
        <div class="text-6xl font-coeliac p-8 text-center">
            {{ $eatery->full_name }}
        </div>

        <div class="grid gap-4 font-sans p-6 z-20 grid-cols-3 max-h-[250px]">
            <div class="object-cover rounded-lg overflow-hidden">
                @if($eatery->reviewImages->count() > 0)
                    <img src="{{ $eatery->reviewImages->first()->path }}" class="w-full h-full object-cover" />
                @endif
            </div>
            <div class="object-cover rounded-lg overflow-hidden">
                @if($eatery->reviewImages->count() > 1)
                    <img src="{{ $eatery->reviewImages->second()->path }}" class="w-full h-full object-cover" />
                @elseif($eatery->county_id === 1 && $eatery->nationwide_branches_count > 0)
                    <div class="bg-secondary rounded-lg p-4 flex flex-col items-center space-y-3 justify-center h-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-12">
                            <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-3xl font-semibold text-center">
                        {{ number_format($eatery->nationwide_branches_count) }}
                    </span>
                        <span class="text-xl text-center">
                        {{ Str::plural('Branch', $eatery->nationwide_branches_count) }}
                    </span>
                    </div>
                @endif
            </div>
            @if($eatery->reviews->count())
                <div class="bg-secondary rounded-lg p-4 flex flex-col items-center space-y-3 justify-center">
                    <div class="text-xl">Rated</div>
                    <div class="flex space-x-2 text-4xl font-bold items-center">
                        <span>{{ $eatery->average_rating }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-12">
                            <path fill-rule="evenodd"
                                  d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="text-xl">From</div>
                    <div class="text-2xl font-semibold text-center">
                            {{ number_format($eatery->reviews->count()) }} {{ Str::plural('Review', $eatery->reviews->count()) }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
