<template>
    <div>
        <navbar-user-mode class="modes" is-client :clients-url="clientsUrl" :insurers-url="insurersUrl"></navbar-user-mode>

        <div class="main-content">
            <sign-bar class="sign" :sign-in-url="signInUrl" :sign-up-url="signUpUrl"></sign-bar>
            <search-form class="search"></search-form>
        </div>
    </div>
</template>

<script>
import NavbarUserMode from '../NavbarUserMode';
import SignBar from '../SignBar';
import SearchForm from '../SearchForm';

export default {
    name: "ClientsPage",

    component: {
        'navbar-user-mode': NavbarUserMode,
        'sign-bar': SignBar,
        'search-form': SearchForm,
    },

    props: {
        clientsUrl: { type: String },
        insurersUrl: { type: String },

        signInUrl: { type: String },
        signUpUrl: { type: String },
    },
}
</script>

<style scoped>
    .main-content {
        background-image: url("/img/client-background.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        height: 40vh;
    }

    .modes {
        padding-top: 1rem;
        padding-right: 1rem;
        padding-left: 1rem;
    }

    .sign {}

    .search {
        padding-left: 5rem;
        padding-right: 5rem;
    }
</style>
