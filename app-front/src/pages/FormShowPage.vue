<template>
    <main
        class="flex items-center justify-center h-screen">
        <div class="
            border-8 border-gray-200 rounded-xl
            w-[500px] -mt-14 p-8
            flex flex-col gap-y-5
        ">
            <div v-if="feedback.isLoaded" class="flex flex-col">
                <h1 class="text-3xl font-medium text-gray-500">{{ feedback.title }}</h1>
                <p class="text-sm text-gray-400">{{ datetime }}</p>
                <p class="text-base mt-2 mb-2 text-gray-500">{{ renderServicename(feedback.service_name) }}</p>
                <Rating :ratingProp="feedback.rating"/>
            </div>
            <div>
                <RouterLink
                    :to="{ name: 'feedback-create' }"
                    class="
                        flex items-center gap-0.5 outline-brand-2
                        text-gray-400
                        transition-colors
                        focus:text-brand-2 hover:text-brand-2
                ">
                    <svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-5 h-6 -mb-0.5"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                    </svg>
                    <span>Новый отзыв</span>
                </RouterLink>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import axios from 'axios';
import { onBeforeMount, reactive, computed } from 'vue';
import { useRoute } from 'vue-router';
import env from '@/env.json';
import Rating from '@/components/Rating/Rating.vue'


const idFromRouter = useRoute().params.id
const feedback = reactive({
    title: '',
    description: '',
    service_name: '',
    rating: 0,
    datetime: '',
    isLoaded: false
});

interface IServiceName {
  [key: string]: string;
}

const renderServicename =(keyService:string) =>{
   
    const servicevariant:IServiceName = {
        shop: "Магазин",
        delivery: "Доставка",
        application: "Приложение",
    }
   
    return servicevariant[keyService]
}


const datetime = computed(() => {
    return new Date(Number(feedback.datetime)).toLocaleString()
})

onBeforeMount(() => {
    axios.get<FeedbackResponse>(env.backend_url + `/feedbacks/${idFromRouter}`)
        .then(feedbackResponse => {
            const feedbackResponseData = feedbackResponse.data;
            feedback.title = feedbackResponseData.title;
            feedback.description = feedbackResponseData.description;
            feedback.service_name = feedbackResponseData.service_name;
            feedback.rating = feedbackResponseData.rating;
            feedback.datetime = feedbackResponseData.datetime;
            feedback.isLoaded = true;
        }).catch(error => {
            alert(error);
        });
});

interface FeedbackResponse {
    title: string;
    description: string;
    service_name: string;
    rating: number;
    datetime: string;
}
</script>
