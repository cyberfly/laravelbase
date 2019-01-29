<v-example-multiform-child
    v-for="(user, index) in users"
    :data="user"
    :index="index"
    :submitted="submitted"
    @on-change="setUser"
    inline-template>

    <div class="col-md-6">
        <div class="block block-rounded block-bordered block-fx-shadow">
            <div class="block-content ribbon ribbon-bookmark ribbon-dark">
                <div class="ribbon-box">User - @{{ user.ic }}</div>

                <!-- show validation error -->
                <v-validation-alert :submitted="submitted"></v-validation-alert>

                <div class="row push">
                    <div class="col-lg-6">

                        <div class="form-group">
                            <v-text
                                    v-model="user.name"
                                    :field_name="'name'"
                                    :label="'Name'"
                                    :rules="'required'"
                            ></v-text>
                        </div>

                        <div class="form-group">
                            <v-text
                                    v-model="user.ic"
                                    :field_name="'ic'"
                                    :label="'IC'"
                                    :rules="'required|numeric'"
                            ></v-text>
                        </div>

                        <div class="form-group">
                            <v-text
                                    v-model="user.email"
                                    :field_name="'email'"
                                    :label="'Email'"
                                    :rules="'required|email'"
                            ></v-text>
                        </div>

                        <div class="form-group">
                            <v-text
                                    v-model="user.phone"
                                    :field_name="'phone'"
                                    :label="'Phone'"
                                    :rules="'required|numeric'"
                            ></v-text>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</v-example-multiform-child>