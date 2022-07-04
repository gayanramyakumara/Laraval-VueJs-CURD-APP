<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 style="padding: 0; margin: 0;">Edit Sales Representative</h4>
                    <router-link
                        :to='{
                            name:"SalesTeamList"
                        }'
                        class="btn btn-primary"
                    >
                        Back to List
                    </router-link>
                </div>
                <div class="card-body">

                   <form @submit.prevent>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>ID</label>
                                    <input id="id" name="ud" type="text" class="form-control" v-model="salesTeam.id" disabled="disabled">
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input id="name" name="name" type="text" class="form-control" v-model="salesTeam.name">
                                    <div v-if="errors.name" class="text-danger">
                                        {{errors.name[0]}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input id="email" name="email" type="email" class="form-control" v-model="salesTeam.email">
                                    <div v-if="errors.email" class="text-danger">
                                        {{errors.email[0]}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Telephone</label>
                                    <input type="text" class="form-control"  v-model="salesTeam.telephone">
                                    <div v-if="errors.telephone" class="text-danger">
                                        {{errors.telephone[0]}}
                                    </div>
                                </div>
                            </div>



                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Joined Date</label>
                                    <input type="date" class="form-control"  v-model="salesTeam.joined_date">
                                    <div v-if="errors.joined_date" class="text-danger">
                                        {{errors.joined_date[0]}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Current Route</label>
                                    <select class="form-control" v-model="salesTeam.current_route">
                                        <option value="">Select an Option</option>
                                        <option value="Barnes Place">Barnes Place</option>
                                        <option value="St. Albans Place">St. Albans Place</option>
                                        <option value="Townhall">Townhall</option>
                                    </select>

                                    <div v-if="errors.current_route" class="text-danger">
                                        {{errors.current_route[0]}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <div class="col-12 d-flex flex-column">
                                        <label>Comments</label>
                                        <textarea class="form-control" v-model="salesTeam.comments" rows="4">
                                        </textarea>
                                    </div>
                                    <div v-if="errors.comments" class="text-danger">
                                        {{errors.comments[0]}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary " @click="update">Save</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>




<script>
export default {
    name:"update-sales-team-member",
    data(){
        return {
            errors:[],
            response_message : "",
            salesTeam: {
                id: "",
                name:"",
                email:"",
                telephone:"",
                current_route:"",
                joined_date: "",
                comments: "",
            }
        }
    },
    mounted(){
        this.showRepresentative()
    },
    methods:{

        checkForm: function (e) {

            this.errors = [];

            if (!this.customer.name) {
                this.errors.push('Name required.');
            }

            if (!this.customer.address) {
                this.errors.push('Address required.');
            }

            if (!this.customer.telephone) {
                this.errors.push('Telephone required.');
            }
            console.log(this.errors);
        },
        async showRepresentative() {
            await this.axios.get(`/api/sales-team/${this.$route.params.id}`).then(response=>{
                this.salesTeam = {
                    ...response.data.data
                };
            }).catch(error=>{
                this.$router.push({name: "SalesTeamList"});
                console.log(error);
            })
        },
        async update(){
            this.errors = [];

            await this.axios.put(`/api/sales-team/${this.salesTeam.id}`, this.salesTeam).then(
                response => {
                    this.response_message = "Sales Rep has been updated";
                    setTimeout(() => this.$router.push({name: "SalesTeamList"}), 1500);
                }
            ).catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            })

        }
    }
}
</script>
