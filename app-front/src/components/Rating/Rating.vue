
<template>
    <div class="relative w-fit">
        <span v-for="n in starLimit" v-on:click="handleClick = n" :key="n"
            class="star__outline inline-block mx-1 shrink-0 w-4 h-4"></span>
        <div class="inline-flex absolute top-0 left-0 w-0 h-100 overflow-hidden" :style="{ width: ratingWidth }">
            <span v-for="n in rating" v-on:click="handleClick = n"
                class="star__full inline-block mx-1 shrink-0 w-4 h-4"></span>
        </div>
    </div>
</template>
  
<script lang="ts">
export default {
    name: 'Rating',

    data() {
        return {
            rating: this.ratingProp,
            starLimit: 5,
        }
    },
    props: ['onRating', 'ratingProp'],
    computed: {
        ratingWidth: function () {
            return this.rating / this.starLimit * 100 + '%';
        },
        handleClick: {
            get: function () { return this.rating },
            set: function (value: number) {
                if (!this.onRating) return
                this.rating = value
                return this.onRating(this.rating)

            }
        }
    },
    watch: {
        rating: function () {
            return this.rating / this.starLimit * 100 + '%';
        }
    }
};

</script>
  
<style>
.star__outline {
    background-image: url('../../../public/img/star-out.svg');
    background-repeat: no-repeat;
    background-position: center;
}

.star__full {
    background-image: url('../../../public/img/star-full.svg');
    background-repeat: no-repeat;
    background-position: center;
}
</style>