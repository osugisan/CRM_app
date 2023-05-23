<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { onMounted, reactive } from 'vue';
import { getToday } from '@/common'
import Chart from '@/Components/Chart.vue'
import ResultTable from '@/Components/ResultTable.vue'

onMounted( () => {
    form.startDate = getToday()
    form.endDate = getToday()
})

const form = reactive({
    startDate: null,
    endDate: null,
    type: 'perDay'
})

const data = reactive({})

const getDate = async () => {
    try {
        await axios.get(route('api.analysis'), {
            params: {
                startDate: form.startDate,
                endDate: form.endDate,
                type: form.type
            }
        }).then ( res => {
            data.data = res.data.data
            data.labels = res.data.labels
            data.totals = res.data.totals
            data.type = res.data.type
            console.log(res)
        })
    } catch(e) {
        console.log(e.message)
    }
}
</script>

<template>
    <Head title="データ分析" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">データ分析</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="getDate">
                            分析方法<br>
                            <input type="radio" name="perDay" value="perDay" v-model="form.type" checked><span class="mr-2">日別</span>
                            <input type="radio" name="perMonth" value="perMonth" v-model="form.type"><span class="mr-2">月別</span>
                            <input type="radio" name="perYear" value="perYear" v-model="form.type"><span class="mr-2">年別</span>
                            <input type="radio" name="decile" value="decile" v-model="form.type"><span class="mr-2">デシル分析</span><br>

                            <input type="date" name="startDate" v-model="form.startDate" />  ～  
                            <input type="date" name="endDate" v-model="form.endDate" /> <br><br>
                            <button class="flex text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">分析する</button>
                        </form>

                        <Chart :data="data" />
                        <ResultTable :data="data"/>

                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>