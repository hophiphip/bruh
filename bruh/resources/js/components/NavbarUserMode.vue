<template>
    <b-nav tabs>
        <b-nav-item v-bind:active="isClient" v-bind:href="clientsUrl">For clients</b-nav-item>
        <b-nav-item v-bind:active="!isClient" v-bind:href="insurersUrl">For insurers</b-nav-item>
    </b-nav>
</template>

<script>
    export default {
        name: "NavbarUserMode",

        props: {
            isClient: {
                type: Boolean,
            },
            clientsUrl: {
                type: String,
            },
            insurersUrl: {
                type: String,
            },
        },

        data() {
            return {};
        }
    }
</script>
