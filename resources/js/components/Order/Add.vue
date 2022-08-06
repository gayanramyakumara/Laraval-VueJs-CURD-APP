<template>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div v-if="response_message" class="p-3">
                    <div div class="alert alert-success" role="alert">
                        {{ response_message }}
                    </div>
                </div>

                <div v-if="common_errors.length != 0" class="p-3">
                    <div div class="alert alert-danger" role="alert">
                        {{ common_errors }}
                    </div>
                </div>
            </div>

            <form @submit.prevent>

                <div class="loader" v-if="loading"></div>
                
                <div class="row">
                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <label>Amount</label>
                            <input
                                id="amount"
                                name="amount"
                                type="text"
                                class="form-control"
                                v-model="orderDetails.amount"
                            />
                            <div v-if="errors.amount" class="text-danger">
                                {{ errors.amount[0] }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <label>Currency</label>
                            <select
                                class="form-control"
                                v-model="orderDetails.currency"
                            >
                                <option value="">Select an Option</option>
                                <option v-for='currency_item in this.currencyData' :value='currency_item'>  {{ currency_item }}</option>
                            </select>

                            <div v-if="errors.currency" class="text-danger">
                                {{ errors.currency[0] }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <label>Email</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                class="form-control"
                                v-model="orderDetails.email"
                            />
                            <div v-if="errors.email" class="text-danger">
                                {{ errors.email[0] }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button
                            type="submit"
                            class="btn btn-primary"
                            @click="createAnOrder"
                        >
                            Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "add-sales-team",
    data() {
        return {
            loading: false,
            common_errors: [],
            errors: [],
            response_message: "",
            orderDetails: {
                amount: "",
                email: "",
                currency: "",
            },
            currencyData :[]
        };
    },
    mounted: function () {
        this.getCurrencyList()
    },
    methods: {

        async getCurrencyList(){

            console.log(this.currencyData1)
            await this.axios.get('/api/currency-list').
                then(response => {
                   this.currencyData = response.data.currency_data;
                     
                }).catch(error=>{
                    console.log(error)
                    this.currencyData = []
                })
        },

        async createAnOrder() {
            this.loading = true;
            this.errors = [];
            this.common_errors = [];

            await this.axios
                .post("/api/order-details", this.orderDetails)
                .then((response) => {
                     this.loading = false;
                    this.response_message = "Order has been created";

                    setTimeout(() => {
                        window.location.href = '/order-history';
                    }, 2000);
                                
                })
                .catch((error) => {
                    this.loading = false;
                    if (error.response.status == 422) {
                        if (error.response.data.type == "common") {
                            this.common_errors = error.response.data.errors;
                        } else {
                            this.errors = error.response.data.errors;
                        }
                    } else {
                        this.common_errors = "Something went wrong.";
                    }
                });
        },
    },
};
</script>
