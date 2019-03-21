<template>

    <div>

        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">List Of Users</h3>
            </div>
            <div class="block-content">

                <form>
                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <v-search-field
                                    v-model="search_data"
                                    :label="'Keyword'"
                                    :search_options="search_options"
                                    @input="getSearchValue"
                            >
                            </v-search-field>

                        </div>

                    </div>

                </form>

                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="text-center" style="width: 100px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                        <tr v-for="user in user_data.data" :key="user.id">
                            <td>
                                {{ user.id }}
                            </td>
                            <td>
                                {{ user.name }}
                            </td>
                            <td>
                                {{ user.email }}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <button @click="showDeleteForm(user.id)" type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <pagination :data="user_data" @pagination-change-page="getUsersData"></pagination>

            </div>
        </div>

    </div>

</template>

<script>

    export default {
        props: {

        },
        mounted() {
            this.getUsersData();
        },
        data () {
            return {
                user_data: {},
                search_data: this.getSearchData(),
                search_options: [
                    {
                        key: 'name',
                        label: 'Name',
                    },
                    {
                        key: 'email',
                        label: 'Email',
                    },
                ],
            }
        },
        created()
        {

        },
        methods: {

            getUsersData(page = 1) {

                const params = {
                    page: page,
                    ...this.search_data
                };

                const url = route('examples.vuepaginations.usersdata', params);

                axios.get(url)
                    .then(response => {
                        this.user_data = response.data;
                    });
            },

            getSearchValue: _.debounce(function (value) {
                let search_value = value.search;

                // perform ajax search

                this.getUsersData();

            }, 300),

            getSearchData() {

                let search_data = {};

                return search_data;
            },

            showDeleteForm(id) {
                console.log(id);
            },

        }
    }
</script>
