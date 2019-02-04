<v-example-invoice-parent :invoice="{{ json_encode($invoice) }}" inline-template>

    <div>

        <!-- parent component form -->

        <form @submit.prevent="handleSubmit">

            <div class="row">
                <div class="col-lg-4">

                </div>
                <div class="col-lg-8">

                    <div class="form-group">
                        <v-text
                                v-model="invoice_data.invoice_number"
                                :field_name="'invoice_number'"
                                :label="'Invoice number'"
                                :rules="'required'"
                        ></v-text>
                    </div>

                    <div class="form-group">
                        <v-text
                                v-model="invoice_data.po_number"
                                :field_name="'po_number'"
                                :label="'PO number'"
                                :rules="'required'"
                        ></v-text>
                    </div>

                    <div class="form-group">
                        <v-date
                                v-model="invoice_data.invoice_date"
                                :field_name="'invoice_date'"
                                :label="'Invoice Date'"
                                :rules="'required'"
                        ></v-date>
                    </div>

                    <div class="form-group">
                        <v-date
                                v-model="invoice_data.payment_due"
                                :field_name="'payment_due'"
                                :label="'Payment Due'"
                                :rules="'required'"
                        ></v-date>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-secondary">Save</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>

        <!--include VueJS child component-->

        @include('examples.invoices.partials.v-invoice-child')

    </div>



</v-example-invoice-parent>