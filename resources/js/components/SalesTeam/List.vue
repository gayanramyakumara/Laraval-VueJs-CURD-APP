<template>
    <div class="row">
        <modal name="addSalesTeamModal" :scrollable="true" height="auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 style="padding: 0; margin: 0;">Add Sales Team Member</h4>
                    <button type="button" class="btn btn-danger" @click="closeAddSalesTeamModal">X</button>
                </div>

                <div class="card-body">
                    <Add />
                </div>
            </div>
        </modal>

        <modal name="viewSalesTeam" :scrollable="true" height="auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 style="padding: 0; margin: 0;">{{ selectedTeamMember.name || '' }}</h4>
                    <button type="button" class="btn btn-danger" @click="exitSalesTeam">X</button>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td>{{selectedTeamMember.id}}</td>
                            </tr>
                            <tr>
                                <td>Full Name</td>
                                <td>{{selectedTeamMember.name}}</td>
                            </tr>
                            <tr>
                                <td>Email Address</td>
                                <td>{{selectedTeamMember.email}}</td>
                            </tr>
                            <tr>
                                <td>Telephone</td>
                                <td>{{selectedTeamMember.telephone}}</td>
                            </tr>

                            <tr>
                                <td>Joined Date</td>
                                <td>{{selectedTeamMember.joined_date}}</td>
                            </tr>

                            <tr>
                                <td>Current Routes</td>
                                <td>{{selectedTeamMember.current_route}}</td>
                            </tr>

                            <tr>
                                <td>Comments</td>
                                <td>{{selectedTeamMember.comments}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </modal>

        <div class="col-12 mb-2 text-end">
            <button class="btn btn-primary" type="button" @click="openAddSalesTeamModal">Add New</button>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Sales Team</h4>
                </div>

                <div class="row">
                    <div v-if="response_message" class="p-3">
                        <div div class="alert alert-success" role="alert">{{response_message}}</div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Telephone</th>
                                    <th>Current Route</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody v-if="salesTeam.length > 0">

                                <tr v-for="(member,key) in salesTeam" :key="key">
                                    <td>{{ member.id }}</td>
                                    <td>{{ member.name }}</td>
                                    <td>{{ member.email }}</td>
                                    <td>{{ member.telephone }}</td>
                                    <td>{{ member.current_route }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            @click="viewSalesTeam(member)"
                                            class="btn btn-primary"
                                        >
                                            View
                                        </button>
                                    </td>
                                    <td>
                                        <router-link
                                            :to='{
                                                name:"SalesTeamEdit",
                                                params:{id:member.id}}'
                                            class="btn btn-success"
                                        >
                                            Edit
                                        </router-link>
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            @click="deleteSalesTeam(member.id)" class="btn btn-danger">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="8" align="center">No Sales Team Member Found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import Add from './Add.vue';

export default {
    name: "salesTeam",
    components: {
        Add
    },

    data(){
        return {
            response_message: "",
            salesTeam: [],
            selectedTeamMember: {},
        }
    },
    mounted(){
        this.getSalesTeam();
    },

    methods:{

        openAddSalesTeamModal() {
            this.$modal.show('addSalesTeamModal');
        },

        closeAddSalesTeamModal() {
            console.log("testing.....")
            this.getSalesTeam();
            this.$modal.hide('addSalesTeamModal');
        },

        async getSalesTeam(){
            await this.axios.get('/api/sales-team').
                then(response => {
                    this.salesTeam = response.data.data
                }).catch(error=>{
                    console.log(error)
                    this.salesTeam = []
                })
        },
        viewSalesTeam(selectedTeamMember) {
            this.selectedTeamMember = selectedTeamMember;
            this.$modal.show('viewSalesTeam');
        },
        exitSalesTeam() {
            this.$modal.hide('viewSalesTeam');
        },
        deleteSalesTeam(id) {
            if (confirm("Are you sure to delete this member?")){
                this.axios.delete(`/api/sales-team/${id}`)
                    .then(
                        response => {
                            this.response_message = "Sales Team Member Deleted.";
                            this.getSalesTeam();
                        }
                    ).catch(error=>{
                        console.log(error)
                    })
            }
        }
    }


}
</script>

<style scoped>

</style>
