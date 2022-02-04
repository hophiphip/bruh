<template>
    <div>
        <div class="alert alert-success" v-if="saved">
            <strong>Success!</strong> Your offer has been saved successfully.
        </div>

        <div class="well well-sm" id="offer-form">
            <form class="form-horizontal" method="post" @submit.prevent="onSubmit">
                <fieldset>
                    <legend class="text-center">Describe your offer</legend>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="name">Name</label>
                        <div class="col-md-9" :class="{'has-error': errors.name}">
                            <input id="name"
                                   v-model="offer.name"
                                   type="text"
                                   placeholder="Your name"
                                   class="form-control">
                            <span v-if="errors.name" class="help-block text-danger">{{ errors.name[0] }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="company">Your company</label>
                        <div class="col-md-9" :class="{'has-error': errors.company}">
                            <input id="company"
                                   v-model="offer.company"
                                   type="text"
                                   placeholder="Your company"
                                   class="form-control">
                            <span v-if="errors.company" class="help-block text-danger">{{ errors.company[0] }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="description">Offer description</label>
                        <div class="col-md-9" :class="{'has-error': errors.description}">
                                    <textarea class="form-control"
                                              id="description"
                                              v-model="offer.description"
                                              placeholder="Please enter your message here..."
                                              rows="5"></textarea>
                            <span v-if="errors.description" class="help-block text-danger">{{ errors.description[0] }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            errors: [],
            saved: false,
            offer: {
                name: null,
                company: null,
                description: null,
            }
        };
    },

    methods: {
        onSubmit() {
            this.saved = false;

            axios.post('api/offers', this.offer)
                .then(({data}) => this.setSuccessMessage())
                .catch(({response}) => this.setErrors(response));
        },

        setErrors(response) {
            this.errors = response.data.errors;
        },

        setSuccessMessage() {
            this.reset();
            this.saved = true;
        },

        reset() {
            this.errors = [];
            this.offer = {name: null, company: null, description: null};
        }
    }
}
</script>
