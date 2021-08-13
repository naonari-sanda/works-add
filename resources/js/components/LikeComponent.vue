<template>
    <div class="container">
        <div class="row justify-content-center mt-1">
            <div class="col-md-12">
                <!-- <div v-if="!authId">
                    <button>いいねゲスト</button>
                    <p>{{ this.liked }}いいね数：{{ this.count }}</p>
                </div> -->
                <div>
                    <button v-if="liked" @click="unlike()">いいね解除</button>
                    <button v-if="!liked" @click="like()">いいね</button>
                    <p>いいね数：{{ this.count }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            liked: 0,
            count: 0,
            authId: 0,
            text: "sss",
        };
    },
    props: {
        jobId: {
            type: Number,
        },
        likeCheck: {
            type: Number,
        },
        likeCount: {
            type: Number,
        },
        userId: {
            type: Number,
        },
    },
    mounted() {
        this.count = this.likeCount;
        this.authId = this.userId;
        this.first_check();
    },
    methods: {
        first_check() {
            const url = "/api/job/" + this.jobId + "/hasliked";

            axios
                .get(url, {
                    user_id: this.authId,
                })
                .then((response) => {
                    this.liked = response.data;
                })
                .catch((error) => {
                    alert(error);
                });
        },
        like(jobId) {
            const url = "/api/job/" + this.jobId + "/like";

            axios
                .post(url, {
                    user_id: this.authId,
                })
                .then((response) => {
                    this.liked = true;
                    this.count += 1;
                })
                .catch((error) => {
                    alert(error);
                });
        },
        unlike() {
            const url = "/api/job/" + this.jobId + "/unlike";

            axios
                .post(url, {
                    user_id: this.userId,
                })
                .then((response) => {
                    this.liked = false;
                    this.count -= 1;
                })
                .catch((error) => {
                    alert(error);
                });
        },
    },
};
</script>
