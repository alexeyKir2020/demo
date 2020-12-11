<template>
    <v-app>

        <v-app-bar app
        >
            <v-app-bar-nav-icon class="d-flex d-md-none" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-spacer></v-spacer>

            <v-menu
                bottom
                min-width="200px"
                rounded
                offset-y
            >
                <template v-slot:activator="{ on }">
                    <v-btn
                        icon
                        x-large
                        v-on="on"
                        class="ml-auto mr-12"
                    >
                        <v-avatar
                            color="primary"
                            dark
                            size="48"
                        >
                            <span class="white--text headline">{{ user.initials }}</span>
                        </v-avatar>
                    </v-btn>
                    <h3 class="d-flex mr-4">{{ user.fullName }}</h3>
                </template>
                <v-card>
                    <v-list-item-content class="justify-center" >
                        <div class="mx-auto text-center">
                            <v-avatar
                                color="primary"
                            >
                                <span class="white--text headline">{{ user.initials }}</span>
                            </v-avatar>
                            <h3>{{ user.fullName }}</h3>
                            <p class="caption mt-1">
                                {{ user.email }}
                            </p>
                            <v-divider class="my-3"></v-divider>
                            <v-btn
                                depressed
                                text
                                link
                                href="/organisation"
                            >
                                Перейти в аккаунт
                            </v-btn>
                            <v-divider class="my-3"></v-divider>
                            <v-btn
                                depressed
                                text
                                link
                                href="/logout"
                            >
                                Выйти
                            </v-btn>
                        </div>
                    </v-list-item-content>
                </v-card>
            </v-menu>


        </v-app-bar>

        <v-navigation-drawer app
            v-model="drawer"
            left
            width="180px"
            :permanent="$vuetify.breakpoint.md"
        >
            <v-list-item link href="/">
                <v-list-item-content>
                    <v-list-item-title class="title pb-1 pt-1">
                        <v-img :src="logo"
                            width="120px"
                            height="32px"
                            contain
                        >
                        </v-img>
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
            <v-list
                dense
                nav
            >
                <v-list-item
                    v-for="item in items"
                    :key="item.title"
                    link
                    :to="item.name"
                >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <!-- Sizes your content based upon application components -->
        <v-main>

            <!-- Provides the application the proper gutter -->
            <v-container fluid>

                <!-- If using vue-router -->
                <router-view></router-view>
            </v-container>
        </v-main>

        <v-footer app>
            <!-- -->
        </v-footer>
    </v-app>
</template>


<script>

    export default {
        name: "Layout",
        props: ['userName', 'userId', 'userToken'],


        data() {
            return {
                //csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                user: {
                    initials: 'TJ',
                    fullName: 'Admin',
                    email: 'admin@teenjob.by',
                },

                drawer: true,
                group: null,
                home: "/",

                items: [
                    { title: 'Организации', icon: 'mdi-domain', name: "organisations" },
                    { title: 'Мероприятия', icon: 'mdi-calendar', name: "events" },
                    { title: 'Работа', icon: 'mdi-briefcase', name: "jobs" },
                    { title: 'Стажировки', icon: 'mdi-school', name: "internships" },
                    { title: 'Волонтерство', icon: 'mdi-hand-heart', name: "volunteerings" },
                    { title: 'Резюме', icon: 'mdi-file-account', name: "resumes" },
                    { title: 'Пользователи', icon: 'mdi-account', name: "users" },
                    { title: 'Права', icon: 'mdi-shield-account', name: "permissions" },
                    { title: 'Настройки', icon: 'mdi-ballot-recount', name: "options" },
                    { title: 'Cтатистика', icon: 'mdi-chart-bar', name: "stats" },
                ],

                logo: '/images/logo/logo.svg'
            }
        },
        created() {
            //localStorage.setItem('access_token', this.$props['userToken']);

        },
        watch: {
            group () {
                this.drawer = false
            },
        },
        methods: {
            submit : function(){
                //this.$refs.form.submit();
            }
        }
    }
</script>

<style lang="scss">


</style>


