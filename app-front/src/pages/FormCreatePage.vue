<template>
    <div class="flex items-center justify-center h-screen">
        <form @submit.prevent="sendForm" class="
            border-8 border-gray-200 rounded-xl
            w-[500px] -mt-14 p-8
            flex flex-col gap-y-3
        ">
            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2" for="title">
                <span class="text-lg">Заголовок</span>
            </label>
            <input id="title"
                class="px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner focus-visible:outline-brand-2 outline-2"
                type="text" v-model="data.title">

            <input v-model="data.datetime" type="datetime-local" />

            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2" for="description">
                <span class="text-lg">Описание</span>
            </label>

            <textarea id="description"
                class="px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner focus-visible:outline-brand-2 outline-2"
                rows="6" v-model="data.description">
            </textarea>


            <label for="service_name" class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Выберите сервис, на который оставляете отзыв</span>
            </label>
            <select id="service_name"
                v-model="data.service_name"
                class="px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner focus-visible:outline-brand-2 outline-2">
                <option selected disabled>Choose a country</option>
                <option value="shop">Магазин</option>
                <option value="delivery">Доставка</option>
                <option value="application">Приложение</option>
            </select>

            <Rating :onRating="onReting" :ratingProp="0"/>
            <button class="
                grid place-content-center w-full p-2 mt-1 border-2 border-gray-300 rounded-md shadow-sm outline-none bg-white
                text-lg font-semibold tracking-wide text-gray-400
                transition-all
                focus-visible:bg-brand-2 focus-visible:border-green-700 focus-visible:text-green-800 focus-visible:shadow-xl
                hover:bg-brand-2 hover:border-green-700 hover:text-green-800 hover:shadow-xl
            " type="submit">Отправить</button>
        </form>
    </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import axios from 'axios';
import env from '@/env.json'
import router from '@/router';
import Rating from '@/components/Rating/Rating.vue'



const data = reactive({
    title: '',
    description: '',
    service_name: '',
    rating: 0,
    datetime: '',
});

const sendForm = async () => {
    try {
        const response = await sendFormImpl();
        if (!response.data.id)
            throw new Error('Ошибка сервера');
        await router.push({ name: 'feedback-show', params: { id: response.data.id } });
    } catch (error) {
        alert(error);
    }
}

const onReting = (value: number) => {
    data.rating = value;
    
}

const sendFormImpl = async () => {
  
    return await axios.post<StoreFeedbackResponse>(env.backend_url + '/feedbacks', {
        'title': data.title,
        'description': data.description,
        'service_name': data.service_name,
        'rating': data.rating,
        'datetime': new Date(data.datetime).getTime()
    });
}

interface StoreFeedbackResponse {
    id: number
}
</script>
