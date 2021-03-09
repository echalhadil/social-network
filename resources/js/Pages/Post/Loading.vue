<template>
    <div  class=" md:w-9/12 mt-4 mx-auto  ">
        <div class=" bg-white rounded-xl p-2 shadow">
            <!-- Post owner -->

            <div class=" w-full flex p-1 ">
                <!-- post owner picture -->
                <div class=" pr-1">
                    <div
                        class="w-13 h-13 loading object-cover rounded-full "
                    ></div>
                </div>
                <!-- post owner picture -->

                <!-- post owner full name -->
                <div class="pl-2 my-auto w-7/12">
                    <div
                        class="text-base w-28 rounded-full loading h-3 font-bold capitalize"
                    ></div>
                    <div
                        class="loading w-13 h-2 mt-1 rounded-full lowercase text-xs"
                    ></div>
                </div>
                <!-- post owner full name -->
            </div>

            <!-- Post owner -->

            <!-- Post text -->
            <div class=" px-1 pt-2 ">
                <p
                    class="w-full rounded-full mt-1 h-2 loading"
                ></p>
                <p
                    class="w-full rounded-full mt-2 h-2loading"
                ></p>
                <p
                    class="w-full rounded-full mt-2 h-2 loading"
                ></p>
                <p
                    class="w-1/3 rounded-full mt-2 h-2 loading"
                ></p>
            </div>

            <div class=" flex p-2 h-10">
                <div
                    class="loading w-11 mt-2 rounded-full h-2 "
                ></div>

                <div
                    class=" ml-2 loading w-11 mt-2 rounded-full h-2"
                ></div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    
}
</script>

<style >
    
    .loading {
    background: linear-gradient(to right, #e5e7eb, #e3e3e3);
    animation: mymove 1s infinite;
}
@keyframes mymove {
    0% {
        background: linear-gradient(to right, #e5e7eb, #e3e3e3);
    }

    50% {
        background: linear-gradient(to right, #e3e3e3, #e3e3e3);
    }

    100% {
        background: linear-gradient(to left, #e5e7eb, #e3e3e3);
    }
}
</style>