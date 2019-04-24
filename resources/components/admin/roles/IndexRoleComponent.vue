<template>

    <div>

        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">List Of Roles</h3>
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
                        <th>Description</th>
                        <th>Permissions</th>
                        <th class="text-center" style="width: 100px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                        <tr v-for="(role, index) in role_data.data" :key="role.id">
                            <td>
                                {{ role.id }}
                            </td>
                            <td>
                                {{ role.name }}
                            </td>
                            <td>
                                {{ role.email }}
                            </td>
                            <td>
                                <v-html-list
                                    :list_data="role.permissions"
                                    :label_key="'name'"
                                ></v-html-list>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a :href="$linkTo('admin.roles.edit', role.id)" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <button @click="$showDeleteForm(role.id, index)" type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <pagination :data="role_data" @pagination-change-page="getRolesData"></pagination>

            </div>
        </div>

    </div>

</template>

<script>

    export default {
        props: {

        },
        mounted() {
            this.getRolesData();
        },
        data () {
            return {
                role_data: {},
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

            listRolePermissions(permissions) {

                console.log(permissions);
            },

            getRolesData(page = 1) {

                this.$showLoading();

                const params = {
                    page: page,
                    ...this.search_data
                };

                const url = route('admin.roles.indexdata', params);

                axios.get(url)
                    .then(response => {
                        this.role_data = response.data;

                        this.$hideLoading();
                    });
            },

            getSearchValue: _.debounce(function (value) {
                let search_value = value.search;

                // perform ajax search

                this.getRolesData();

            }, 300),

            getSearchData() {

                let search_data = {};

                return search_data;
            },

            destroy(id, index) {

                this.$showLoading();

                axios
                    .delete(route('admin.roles.destroy', id))
                    .then(response => {

                        this.$hideLoading();

                        // delete row
                        this.role_data.data.splice(index, 1);

                        console.log('res -->', response);

                        // success notification

                        this.$showSuccessDeleted('Role');

                    })
                    .catch(function (error) {
                        console.log('error res -->', error);
                    });
            },

        }
    }
</script>
