<template>
    <v-dialog
        v-model="show"
        max-width="600px"
    >
        <v-card>
            <v-card-title>
                <span class="headline">{{ sync_dialog.title }}</span>
            </v-card-title>

            <v-card-text>
                <v-container>
                    <v-form
                        ref="form"
                        v-model="rules.valid"
                        lazy-validation
                    >
                        <v-row>
                            <v-col
                                cols="12"
                                sm="12"
                                md="12"
                            >
                                <v-text-field
                                    v-model="sync_dialog.item.title"
                                    :rules="rules.title"
                                    label="Название"
                                    required
                                ></v-text-field>

                            </v-col>

                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model="sync_dialog.item.link"
                                    :rules="rules.link"
                                    label="Ссылка"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-select
                                    :items="meta.organisation_types"
                                    v-model="sync_dialog.item.type.id"
                                    item-value="id"
                                    item-text="name"
                                    label="Тип"
                                ></v-select>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-autocomplete
                                    :items="meta.cities"
                                    label="Город"
                                    clearable
                                    v-model="sync_dialog.item.city.id"
                                    prepend-icon="mdi-city"
                                    placeholder="Все города"
                                    item-value="id"
                                    item-text="name"
                                ></v-autocomplete>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model="sync_dialog.item.reg_number"
                                    label="УНП"
                                    v-mask="'#########'"
                                    :rules="rules.reg_number"
                                ></v-text-field>
                            </v-col>

                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model="sync_dialog.item.email"
                                    label="email"
                                    :rules="rules.email"
                                ></v-text-field>
                            </v-col>

                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model="sync_dialog.item.contact_person"
                                    :rules="rules.contact_person"
                                    label="Представитель"
                                ></v-text-field>
                            </v-col>

                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model="sync_dialog.item.phone"
                                    label="Телефон"
                                    :placeholder="'+'"
                                    v-mask="'+##############'"
                                    :rules="rules.phone"
                                ></v-text-field>
                            </v-col>

                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model="sync_dialog.item.addition_email"
                                    label="Дополнительный email"
                                    :rules="rules.addition_email"
                                ></v-text-field>
                            </v-col>

                            <v-col
                                cols="12"
                                sm="6"
                                md="6"
                            >
                                <v-text-field
                                    v-model="sync_dialog.item.addition_phone"
                                    :placeholder="'+'"
                                    v-mask="'+##############'"
                                    label="Дополнительный телефон"
                                    :rules="rules.addition_phone"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="primary darken-1"
                    text
                    @click.stop="show=false"
                >
                    Отмена
                </v-btn>
                <v-btn
                    color="primary darken-1"
                    text
                    @click="confirm('create')"
                >
                    Сохранить
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import VDialogDelete from '../common/DialogDelete'
import { VDigitalTimePicker } from 'v-digital-time-picker'
import validationRules from "../common/validationRules";

export default {

    props: ['value', 'meta', 'dialog'],
    components: {
        VDialogDelete,
        VDigitalTimePicker,
    },

    data: () => ({

        rules: {

            title: [
                v => !!v || 'Введите название',
                v => (v && v.length <= 255) || 'Максимум 255 символов',
            ],

            link: [
                v => v.length <= 255 || 'Максимум 255 символов',
            ],

            reg_number: [
                v => !!v || 'Введите УНП',
                v => v.length == 9 || 'Необходимо 9 цифр',
                v => validationRules.digitsRegexp.test(v) || 'Допускаются только цифры'
            ],

            email: [
                v => !!v || 'Введите почтовый адрес',
                v => v.length <= 255 || 'Максимум 255 символов',
                v => validationRules.emailRegexp.test(v) || 'Неверный формат'
            ],

            contact_person: [
                v => !!v || 'Введите контактное лицо',
                v => v.length <= 255 || 'Максимум 255 символов',
            ],

            phone: [
                v => !!v || 'Введите телефон',
                v => v.length <= 100 || 'Максимум 100 символов',
                v => validationRules.phoneRegexp.test(v) || 'Допускаются только цифры'
            ],

            addition_phone: [
                v => v.length <= 100 || 'Максимум 100 символов',
                v => validationRules.phoneRegexp.test(v) || 'Допускаются только цифры'
            ],

            addition_email: [
                v => v.length <= 255 || 'Максимум 255 символов',
                v => validationRules.emailRegexp.test(v) || 'Неверный формат'
            ],

            type: [
                v => !!v || 'Введите тип организации',
            ],

            valid: true,
        },
    }),

    computed: {

        sync_dialog: {
            get() {
                return this.dialog
            },
            set(val) {
                this.$emit('update:dialog', val)
            }
        },

        show: {
            get () {
                return this.value
            },
            set (value) {
                this.$emit('input', value)
            }
        }
    },

    methods: {

        validate () {
            this.$refs.form.validate()
            return this.rules.valid;
        },

        reset () {
            this.$refs.form.reset()
        },

        resetValidation () {
            this.$refs.form.resetValidation()
        },

        confirm() {
            if(this.validate())
                this.$emit("confirm")
        }
    }
}

</script>
<style scoped>

.image-upload {
    width: 100%;
    height: auto;
    min-height: 200px;
    border: 3px dashed rgba(0, 0, 0, 0.54);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

.image-remove {
    top: 0;
    right: 0;
}

.image-upload-preview {
    width: 100%;
    height: auto;
    max-width: 220px;
    position: relative;
}
</style>
