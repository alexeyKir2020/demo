<template>
    <v-dialog v-model="show" max-width="500px">
        <v-card>
            <v-card-title class="headline">Вы уверены, что хотите удалить {{ text }}?</v-card-title>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary darken-1" text @click.stop="show=false">Отмена</v-btn>
                <v-btn color="primary darken-1" text @click="confirm">ОК</v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

export default {

    props: {
        value: Boolean,
        text: String
    },
    computed: {
        show: {
            get () {
                return this.value
            },
            set (value) {
                this.$emit('input', value)
            }
        }
    },

    methods : {
        confirm() {
            this.$emit("confirm");
        }
    }
}
</script>

<style scoped>

</style>
