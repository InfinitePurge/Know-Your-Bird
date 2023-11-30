<style>

.bakugroundu{
background: rgb(255,255,255);
background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(0,0,0,0.6138830532212884) 100%);

}

</style>

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bakugroundu">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
