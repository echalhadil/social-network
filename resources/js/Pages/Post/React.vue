<template>
    <div class=" flex p-2 text-gray-400 h-10">
        <!-- react -->
        <div class="my-auto react pr-1">
            <div
                class="list-none shadow-lg dropdown-menu mt-4 hidden -ml-7 absolute text-gray-800 w-48 rounded bg-white p-2"
            >
                <img
                    class="h-7 mx-auto"
                    @click="
                        reacting(
                            'https://www.flaticon.com/svg/static/icons/svg/1182/1182670.svg',
                            'like'
                        )
                    "
                    src="https://www.flaticon.com/svg/static/icons/svg/1182/1182670.svg"
                />
                <img
                    class="h-7 mx-auto"
                    @click="
                        reacting(
                            'https://www.flaticon.com/svg/static/icons/svg/1182/1182669.svg',
                            'love'
                        )
                    "
                    src="https://www.flaticon.com/svg/static/icons/svg/1182/1182669.svg"
                />
                <img
                    class="h-7 mx-auto"
                    @click="
                        reacting(
                            'https://www.flaticon.com/svg/static/icons/svg/742/742920.svg',
                            'happy'
                        )
                    "
                    src="https://www.flaticon.com/svg/static/icons/svg/742/742920.svg"
                />
                <img
                    class="h-7 mx-auto"
                    @click="
                        reacting(
                            'https://www.flaticon.com/svg/static/icons/svg/725/725038.svg',
                            'sad'
                        )
                    "
                    src="https://www.flaticon.com/svg/static/icons/svg/725/725038.svg"
                />
            </div>
            <img
                class="h-4 mx-auto my-auto"
                @click="reacting('/img/react/like.png', 'unlike')"
                :src="currentreaction"
            />
        </div>

        <!-- react -->

        <!-- likes -->
        <div class=" likes cursor-pointer ">
            <p class=" hover:text-cool-gray-500 ">{{ reacts.length }} reacts</p>
            <div
                v-if="reacts.length > 0"
                class="list-none dropdown-menu hidden absolute bg-gray-800 w-40 rounded text-white p-2"
            >
                <li
                    v-for="react in reacts"
                    :key="react.id"
                    class="hover:text-gray-300"
                >
                    {{ react.user.firstname }} {{ react.user.lastname }}
                </li>
            </div>
        </div>
        <!-- likes -->

        <!-- comments -->
        <div class=" comments pl-4 cursor-pointer ">
            <div class="flex">
                <i class="fa fa-comment my-auto pr-1" aria-hidden="true"></i>
                <p class="my-auto hover:text-cool-gray-500 ">
                    {{ comments.length }} comments
                </p>
            </div>
            <div
                v-if="comments.length > 0"
                class="list-none dropdown-menu hidden absolute bg-gray-800 w-40 rounded text-white p-2"
            >
                <li
                    v-for="comment in whoCommented"
                    :key="comment.id"
                    class="hover:text-gray-300"
                >
                    {{ comment.user.firstname }} {{ comment.user.lastname }}
                </li>
            </div>
        </div>
        <!-- comments -->
    </div>
</template>

<script>
export default {
    props: ["comments", "reacts", "post", "userid", "isReacted"],

    data() {
        return {
            currentreaction: "/img/react/like.png"
        };
    },
    methods: {
        reacting(link, type) {
            this.currentreaction = link;

            console.log(type);

            let post_id = this.post.id;

            let react = this.reacts.filter(r => r.user_id == this.userid);

            if (this.isReacted && type == "unlike") {
                axios
                    .delete("/reacts/" + react[0].id)
                    .then(response => {
                        console.log(response);
                        this.$emit("unreact", react[0], this.post);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            } else if (
                (!this.isReacted || type != react[0].type) &&
                type != "unlike"
            )
                axios
                    .post("/reacts", { post_id, type })
                    .then(response => {
                        console.log(response.data);
                        if (response.data != "update")
                            this.$emit("react", response.data, this.post);
                    })
                    .catch(error => {
                        console.log(error);
                    });
        },
        reaction() {
            let yourReaction = this.reacts.filter(
                c => c.user_id == this.userid
            );

            console.log(yourReaction);
            if (this.isReacted)
                if (yourReaction.length > 0) {
                    if (yourReaction[0].type == "like")
                        this.currentreaction =
                            "https://www.flaticon.com/svg/static/icons/svg/1182/1182670.svg";

                    if (yourReaction[0].type == "love")
                        this.currentreaction =
                            "https://www.flaticon.com/svg/static/icons/svg/1182/1182669.svg";

                    if (yourReaction[0].type == "happy")
                        this.currentreaction =
                            "https://www.flaticon.com/svg/static/icons/svg/742/742920.svg";

                    if (yourReaction[0].type == "sad")
                        this.currentreaction =
                            "https://www.flaticon.com/svg/static/icons/svg/725/725038.svg";
                }

            if (!this.isReacted) this.currentreaction = "/img/react/like.png";
        }
    },
    computed: {
        whoCommented() {
            return _.uniqBy(this.post.comments, "user.id");
        }
    },
    mounted() {
        this.reaction();
    }
};
</script>

<style>
.likes:hover .dropdown-menu {
    display: block;
}

.comments:hover .dropdown-menu {
    display: block;
}

.react:hover .dropdown-menu {
    display: flex;
}

.option:hover .dropdown-menu {
    display: block;
}
</style>
