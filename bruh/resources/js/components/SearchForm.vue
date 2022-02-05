<template>
    <div>
        <b-form class="search-form">
            <b-form-input v-model="text" placeholder="Enter your insurance case"></b-form-input>
            <b-button type="submit">Search</b-button>
        </b-form>
    </div>
</template>

<script>
export default {
    name: "SearchForm",

    data() {
        return {
            text: '',
        }
    }
}
</script>

<style scoped>
    .search-form {
        display: flex;
    }
</style>
