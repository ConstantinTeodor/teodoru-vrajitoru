@extends('layout')

@section('seo')
    <title>{!! config('app.name') !!}</title>
@endsection

@section('content')
    <div class="flex flex-col justify-center items-center w-full text-center">
        <div class="mt-[300px] mb-6">
            <h1 class="text-4xl font-bold text-primary flex items-center justify-center gap-3">
                🎄 Christmas Countdown 🎅
            </h1>

            <div id="countdown" class="text-3xl font-semibold text-red-600 mt-4">
                Loading...
            </div>

            <p class="mt-4 text-lg text-green-700 italic">
                It's the most wonderful time of the year! ⭐
            </p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function updateCountdown() {
                const christmas = new Date(new Date().getFullYear(), 11, 25, 0, 0, 0); // Month = 11 (December)
                const now = new Date();

                // If Christmas has passed this year, countdown to next year
                if (now > christmas) {
                    christmas.setFullYear(christmas.getFullYear() + 1);
                }

                const diff = christmas - now;

                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
                const minutes = Math.floor((diff / (1000 * 60)) % 60);
                const seconds = Math.floor((diff / 1000) % 60);

                document.getElementById("countdown").innerHTML =
                    `${days}d : ${hours}h : ${minutes}m : ${seconds}s`;
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    </script>
@endsection
