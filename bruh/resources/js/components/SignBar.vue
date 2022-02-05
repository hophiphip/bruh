<template>
    <b-container class="sign-row">
        <p class="logo" style="flex-grow: 0;">bruh!</p>

        <div style="flex-grow: 1;"></div>

        <a v-bind:href="this.signInUrl" class="sign-button">
            <b-button class="sign-button" variant="outline-success">Sign up</b-button>
        </a>

        <a v-bind:href="this.signUpUrl" class="sign-button">
            <b-button class="sign-button" variant="outline-secondary">Sign in</b-button>
        </a>
    </b-container>
</template>

<script>
export default {
    name: "SignBar",

    props: {
        signInUrl: {
            type: String,
        },
        signUpUrl: {
            type: String,
        },
    },

    data() {
        return {};
    }
}
</script>

<style scoped lang="scss">
    @import url('https://fonts.googleapis.com/css?family=Rochester');

    .sign-row {
        display: flex;
    }

    .sign-button {
        flex-grow: 0;

        margin-left: .25rem;

        /* TODO: Centered vertically the worst way possible */
        top: 30%;
        -ms-transform: translateY(30%);
        transform: translateY(30%);
    }

    .logo {
        font-family: Rochester, cursive;
        font-style: normal;
        font-weight: normal;
        font-size: 5rem;
        align-items: center;
        text-align: center;

        color: #DF0EF1;
    }
</style>
