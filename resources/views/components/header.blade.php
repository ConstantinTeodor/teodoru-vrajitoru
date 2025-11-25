<header class="relative w-full flex items-center justify-center h-[100px] bg-primary shadow-header z-30">
    <div class="w-full lg:max-w-[1200px] px-[15px] flex flex-row justify-between">
        <div class="flex items-center gap-4">
            <img src="{{ asset('storage/assets/logo.png') }}" alt="PMN Logo" class="h-[60px] w-auto">
            <h1 class="text-2xl text-white">{!! config('app.name') !!}</h1>
        </div>

        <nav class="flex items-center justify-center">
            <ul class="flex gap-[35px] font-medium text-white">
                <li><a href="#" class="">{!! __('general.home') !!}</a></li>
                <li><a href="#" class="">{!! __('general.team') !!}</a></li>
                <li><a href="#" class="">{!! __('general.practices') !!}</a></li>
                <li><a href="#" class="">{!! __('general.news') !!}</a></li>
                <li><a href="#" class="">{!! __('general.careers') !!}</a></li>
            </ul>
        </nav>
    </div>
</header>
