<template>
    <div class=" w-full px-2 py-3 bg-white flex shadow-lg">
        <div class=" pr-1 ">
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
