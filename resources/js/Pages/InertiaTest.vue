<script setup>
import { Link } from '@inertiajs/inertia-vue3'
import { ref } from 'vue'

const newTitle = ref('')
const newContent = ref('')
</script>

<template>
  InertiaTest <br>
  <a href="/">aタグ</a> <br>
  <Link href="/">Linkタグ</Link>
  <Link :href="route('inertia.index')">名前付きルート</Link> <br>
  <Link :href="route('inertia.show', { id: 50 })">show</Link>

  <div class="mb-8"></div>

  <input type="text" name="newTitle" v-model="newTitle"> {{ newTitle }}
  <input type="text" name="newContent" v-model="newContent"> {{ newContent }}
  <Link as="button" method="post" :href="route('inertia.store')"
    :data="{
      title: newTitle,
      content: newContent
    }">
    submit
  </Link>
  
</template>