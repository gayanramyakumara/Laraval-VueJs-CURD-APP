<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Order history</h4>
                </div>

                <div class="row">
                    <div v-if="response_message" class="p-3">
                        <div div class="alert alert-success" role="alert">
                            {{ response_message }}
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Amount</th>
                                    <th>Currency</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody v-if="this.orderDetails.data !='' ">
                                <tr v-for="(member, key) of this.orderDetails
                                .data" :key="key">
                                    <td>{{ member.id }}</td>
                                    <td>{{  member.amount.toFixed(2) }}</td>
                                    <td>{{ member.currency }}</td>
                                    <td>{{ member.email }}</td>
                                    <td><span class="label label-info custom-lbl">{{ member.status }} </span></td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="8" align="center">
                                        
                                        No orders are available.

                                        <router-link exact-active-class="active" to="/" class="btn btn-outline-primary">
                                            Create
                                        </router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <pagination align="center" :data="orderDetails" @pagination-change-page="getorderDetails">
                        </pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Add from "./Add.vue";
import pagination from "laravel-vue-pagination";

export default {
    name: "orderDetails",
    components: {
        Add,
        pagination,
    },

    data() {
        return {
            response_message: "",
            orderDetails: {},
            selectedTeamMember: {},
        };
    },
    mounted() {
        this.getorderDetails();
    },

    methods: {
        async getorderDetails(page) {
            if (typeof page === "undefined") {
                page = 1;
            }

            await this.axios
                .get("/api/order-details?page=" + page)
                .then((response) => {
                    this.orderDetails = response.data;
                })
                .catch((error) => {
                    console.log(error);
                    this.orderDetails = [];
                });
        },
    },
};
</script>

<style scoped>
.pagination {
    margin-bottom: 0;
}
</style>
