<template>
    <div>

        <div class="panel panel-default" v-for="offer in offers">

            <div class="panel-heading">
                <span class="glyphicon glyphicon-user" id="start"></span>
                <label id="started">By</label> {{ offer.name }}
            </div>

            <div class="panel-body">
                <div class="col-md-2">
                    <div class="thumbnail">
                        <img src="https://picsum.photos/100" :alt="offer.name">
                    </div>
                </div>
                <p>{{ offer.description }}</p>
            </div>

            <div class="panel-footer">
                <span class="glyphicon glyphicon-calendar" id="visit"></span> {{ offer.date }}
            </div>

        </div>

        <paginate
            :page-count="pageCount"
            :click-handler="fetch"
            :prev-text="'Prev'"
            :next-text="'Next'"
            :container-class="'pagination'">
        </paginate>

    </div>
</template>

<script>
export default {

    data() {
        return {
            offers: [],
            pageCount: 1,
            endpoint: 'api/offers?page='
        };
    },

    created() {
        this.fetch();
    },

    methods: {
        fetch(page = 1) {
            axios.get(this.endpoint + page)
                .then(({data}) => {
                    this.offers = data.data;
                    this.pageCount = data.meta.last_page;
                });
        },
    }
}
</script>
