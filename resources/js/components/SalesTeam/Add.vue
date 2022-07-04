<template>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div v-if="response_message" class="p-3">
                    <div div class="alert alert-success" role="alert">{{response_message}}</div>
                </div>
            </div>

            <form @submit.prevent>
                <div class="row">
                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <label>Name</label>
                            <input id="name" name="name" type="text" class="form-control" v-model="salesTeam.name">
                            <div v-if="errors.name" class="text-danger">
                                {{errors.name[0]}}
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-2">
                        <div class="form-group">
                            <label>Email</label>
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
                            <label>Joined Date</label>
                            <input type="date" class="form-control"  v-model="salesTeam.joined_date">
                            <div v-if="errors.joined_date" class="text-danger">
                                {{errors.joined_date[0]}}
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

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary" @click="createSalesTeamMember">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>



<script>
export default {
    name:"add-sales-team",
    data(){
        return {
            errors: [],
            response_message : "",
            salesTeam:{
                name:"",
                email:"",
                telephone:"",
                current_route:"",
                joined_date: "",
                comments: "",
            }
        }
    },
    mounted: function() {

    },
    methods:{
        async createSalesTeamMember(){
            this.errors = [];

            await this.axios.post('/api/sales-team',this.salesTeam).then(response=>{
                this.response_message = "Sales Team Member created";
            }).catch(error=>{
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                } else {
                    this.response_msesage = "Something went wrong.";
                }
            });
        }
    }
}
</script>
