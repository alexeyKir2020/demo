<template>

    <v-data-table
        :headers="headers"
        :items="data.items"
        sort-by="created_at"
        sort-desc
        class="elevation-1"
        :loading="dataTable.loading"
        loading-text="Загрузка... Пожалуйста подождите"
        :footer-props="{'items-per-page-text': text.onPage}"
        :search="dataTable.search"
        no-data-text="Новых записей нет"
        no-results-text="Ничего не найдено"
    >
        <template v-slot:top>
            <div class="d-flex flex-column flex-lg-row"
            >
                <v-toolbar-title>
                    <v-tabs
                    >
                        <v-tab @click="setTab(status.WAITING_APPROVAL, 'pending')">
                            <v-badge
                                color="red"
                                :content="badgeCounter"
                                :value="badgeCounter"
                            >
                                На модерацию
                            </v-badge>
                        </v-tab>
                        <v-tab @click="setTab(status.PUBLISHED,'approved')">Опубликованные</v-tab>
                        <v-tab @click="setTab(status.ARCHIVED,'archived')">Архив</v-tab>
                        <v-tab @click="setTab(status.SUSPENDED, 'suspended')">Заблокированные</v-tab>
                        <v-tab @click="setTab('', 'all')">Все</v-tab>
                    </v-tabs>
                </v-toolbar-title>

                <v-toolbar-title class="d-flex ml-auto pl-4 pr-4 pr-lg-0 mt-4 mt-lg-0">
                    <v-text-field
                        v-model="dataTable.search"
                        append-icon="mdi-magnify"
                        label="Найти"
                        single-line
                        class="mb-2 pt-0 mr-4"
                        hide-details
                    ></v-text-field>
                    <v-btn
                        color="primary"
                        dark
                        class="mb-2 mr-lg-12"
                        @click="action('create', dialog.create.item,true)"
                    >
                        Создать
                    </v-btn>
                    <v-snackbar
                        :timeout="3000"
                        v-model="notification.status"
                        :value="notification.status"
                        absolute
                        bottom
                        color="primary"
                        text
                    >
                        {{ notification.text }}
                    </v-snackbar>

                    <v-item-dialog :dialog="dialog.create" v-model="dialog.create.open"  :meta="data.meta" @confirm="confirm('create')"></v-item-dialog>
                    <v-item-dialog :dialog="dialog.edit" v-model="dialog.edit.open"  :meta="data.meta" @confirm="confirm('edit')"></v-item-dialog>
                    <v-dialog-delete :text="dialog.delete.text.edit" v-model="dialog.delete.open" @confirm="confirm('delete')"></v-dialog-delete>

                </v-toolbar-title>
            </div>
        </template>
        <template v-slot:item.title="{ item }">
            <v-edit-dialog
                :return-value.sync="dialog.edit.item.title"
                @save="confirm('edit')"
                @cancel="cancelField"
                @open="action('edit', item, false)"
                @close="closeField"
            >
                {{ item.title }}
                <template v-slot:input>
                    <v-text-field
                        v-model="item.title"
                        label="Изменить"
                        single-line
                        counter
                    ></v-text-field>
                </template>
            </v-edit-dialog>
        </template>
        <template v-slot:item.type="{ item }">
            <v-edit-dialog
                :return-value.sync="item.type.id"
                @save="saveField"
                @cancel="cancelField"
                @open="openField"
                @close="closeField"
            >
                {{ item.type.name }}
                <template v-slot:input>
                    <v-select
                        v-model="item.type.id"
                        :items="data.meta.organisation_types"
                        item-value="id"
                        item-text="name"
                        label="Тип"
                    ></v-select>
                </template>
            </v-edit-dialog>
        </template>
        <template v-slot:item.created_at="{ item }">
            {{ new Date(item.created_at).toLocaleString() }}
        </template>
        <template v-slot:item.actions="{ item }">
            <v-tooltip id="approve" v-if="!(activeTab === 'approved')" bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="action('approve', item, false)"
                        v-bind="attrs"
                        v-on="on"
                    >
                        mdi-check-decagram
                    </v-icon>
                </template>
                <span>Опубликовать</span>
            </v-tooltip>
            <v-tooltip id="suspend" v-if="!(activeTab === 'suspended')" bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="action('suspend', item, false)"
                        v-bind="attrs"
                        v-on="on"
                    >
                        mdi-cancel
                    </v-icon>
                </template>
                <span>Заблокировать</span>
            </v-tooltip>
            <v-tooltip id="archive" v-if="!(activeTab === 'archived')" bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="action('archive', item, false)"
                        v-bind="attrs"
                        v-on="on"
                    >
                        mdi-archive-arrow-down
                    </v-icon>
                </template>
                <span>Архивировать</span>
            </v-tooltip>
            <v-tooltip id="edit" bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="action('edit', item, true)"
                        v-bind="attrs"
                        v-on="on"
                    >
                        mdi-pencil
                    </v-icon>
                </template>
                <span>Редактировать</span>
            </v-tooltip>
            <v-tooltip id="delete" bottom>
                <template v-slot:activator="{ on, attrs }">
                    <v-icon
                        small
                        @click="action('delete', item, true)"
                        v-bind="attrs"
                        v-on="on"
                    >
                        mdi-delete
                    </v-icon>
                </template>
                <span>Удалить</span>
            </v-tooltip>
        </template>
        <template v-slot:no-data>
            <v-btn
                color="primary"
                @click="initialize"
            >
                Перезагрузить
            </v-btn>
        </template>
        <template v-slot:footer.page-text="props">
            {{props.pageStart}}-{{props.pageStop}} из {{props.itemsLength}}
        </template>
    </v-data-table>
</template>

<script>
import CRUDPage from "../common/CRUDPage.js"
import entity from "../../data/Organisation.js"
import dataTable from "../common/DataTable.js"
import Statuses from "../common/Statuses"
import VDialogDelete from '../common/DialogDelete'
import VItemDialog from "./Dialog"

export default {
    mixins: [CRUDPage],

    components: {
        VDialogDelete,
        VItemDialog
    },

    data: () => ({
        data: entity.data,
        dataTable: dataTable,
        SLUG: entity.SLUG,

        text: entity.text,
        rules: entity.rules,

        dialog: {
            defaultItem: entity.item,
            create: {
                title: "Создание " + entity.text.new,
                open: false,
                item: entity.item,
                index: -1,
                method: 'post',
                onSuccess: 'Создано успешно',
                onError: 'Ошибка сохранения',
                data:'',
                status: Statuses.CREATED
            },
            edit: {
                title: "Редактирование " + entity.text.edit,
                open: false,
                item: entity.item,
                index: -1,
                method: 'put',
                onSuccess: 'Отредактировано успешно',
                onError: 'Ошибка сохранения',
                data:'',
                status: Statuses.UPDATED
            },
            delete: {
                text: entity.text.new,
                open: false,
                item: entity.item,
                index: -1,
                method: 'delete',
                onSuccess: 'Удалено успешно',
                onError: 'Ошибка удаления',
                data:'',
                status: Statuses.DELETED
            },
            approve: {
                open: false,
                item: entity.item,
                index: -1,
                method: 'patch',
                onSuccess: 'Опубликовано успешно',
                onError: 'Ошибка публикации',
                data:'',
                status: Statuses.APPROVED
            },

            archive: {
                open: false,
                item: entity.item,
                index: -1,
                method: 'patch',
                onSuccess: 'Заархивировано успешно',
                onError: 'Ошибка при архивации',
                data:'',
                status: Statuses.ARCHIVED
            },

            suspend: {
                open: false,
                item: entity.item,
                index: -1,
                method: 'patch',
                onSuccess: 'Блокировка успешно выполнена',
                onError: 'Ошибка блокировки',
                data:'',
                status: Statuses.SUSPENDED
            },
        },

        activeTab: 'moderation',

        status: Statuses,

        notification: {
            status: false,
            text: ``,
        }
    }),

    computed: {
        headers() {
            return [
                {
                    text: 'Название',
                    align: 'start',
                    sortable: true,
                    value: 'title',
                },
                { text: 'Тип', value: 'type.name', sortable: true },
                { text: 'УНП', value: 'reg_number', sortable: true },
                { text: 'Представитель', value: 'contact_person', sortable: true },
                { text: 'Email', value: 'email', sortable: true },
                { text: 'Телефон', value: 'phone', sortable: true },
                { text: 'Создано', value: 'created_at', sortable: true },
                { text: 'Действия', value: 'actions', sortable: false },
                { text: 'Статус', value: 'status', align: ' d-none',
                    filter: value => {
                        if (!this.dataTable.filter.status) return true;
                        return value == this.dataTable.filter.status;
                }},
            ]
        }
    },
}
</script>

<style scoped>

</style>
