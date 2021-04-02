<template>
    <div class=" w-full px-2 py-3 bg-white flex shadow-lg">
        <inertia-link href="/messenger" class=" text-gray-500 sm:w-0 my-auto p-1 visible sm:invisible ">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </inertia-link>
        <div class=" pr-1 my-auto ">
            <img
                :src="'/' + $page.friend.picture"
                class="w-10 h-10 rounded-full my-auto"
            />
        </div>
        <div class=" capitalize my-auto ">
            <p class=" font-bold text-lg ">
                {{ $page.friend.firstname }} {{ $page.friend.lastname }}
            </p>
            <p class=" text-sm text-gray-500 ">online</p>
        </div>
    </div>
</template>
