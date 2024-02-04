<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- showing notification list  -->
                <div class="card notifications">
                    <div class="card-header text-capitalize">
                        <p v-if="unreadNotifications.length > 0">{{ unreadNotifications.length }} New
                            Notifications
                        </p>
                        <p v-else>No new notifications</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-start">
                            <button class="text-muted btn " @click="readAll()">Mark all read</button>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="text-muted btn" @click="clearAll()">Clear all</button>
                        </div>
                    </div>
                    <hr>
                    <div class="p-1">
                        <ul class="list-group notifications-list">
                            <li v-for="notification, key in unreadNotifications" :key="key"
                                class="list-group-item active my-1 ">
                                <a :href="notification.data.click_action ?? '#'" class="">
                                    <div class="row">
                                        <div class="col-md-2 notification-icon">
                                            <img class="img-fluid" v-if="notification.image" :src="notification.image">
                                            <i v-else-if="notification.icon" :class="notification.icon"></i>
                                            <i v-else class="fas fa-bell"></i>
                                        </div>
                                        <div class="col-md-8 notification-panel">
                                            <h3>{{ notification.title }}</h3>
                                            <p>
                                                {{ notification.body }}
                                            </p>
                                        </div>
                                        <div class="col-md-2 notification-date">
                                            <p class="tx-12 text-muted">
                                                {{ notification.data.created_at }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li v-for="notification, key in readNotifications" :key="key" class="list-group-item  my-1 ">
                                <a :href="notification.data.click_action ?? '#'" class="">
                                    <div class="row">
                                        <div class="col-md-2 notification-icon">
                                            <img class="img-fluid" v-if="notification.image" :src="notification.image">
                                            <i v-else-if="notification.icon" :class="notification.icon"></i>
                                            <i v-else class="fas fa-bell"></i>
                                        </div>
                                        <div class="col-md-8 notification-panel">
                                            <h3>{{ notification.title }}</h3>
                                            <p>
                                                {{ notification.body }}
                                            </p>
                                        </div>
                                        <div class="col-md-2 notification-date">
                                            <p class="tx-12 text-muted">
                                                {{ notification.data.created_at }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <!-- if  readNotifications and unreadNotifications is empty-->
                            <li v-if="unreadNotifications.length == 0 && readNotifications.length == 0">
                                <p class="text-muted text-center"> No notifications</p>
                            </li>
                            <!-- if  readNotifications and unreadNotifications is empty-->
                        </ul>

                    </div>
                    <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top"
                        v-if="unreadNotifications.length > 0 || readNotifications.length > 0">
                        <a href="javascript:;">View all</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'user',
        'notificationListUrl',
        'notificationReadAllUrl',
        'notificationClearAllUrl',
    ],
    data() {
        return {
            authUser: JSON.parse(this.user),
            unreadNotifications: [],
            readNotifications: [],
        }
    },
    mounted() {
        // console.log('Component mounted.')
    },

    created() {
        this.listen();
        this.getNotifications();
    },
    methods: {
        listen() {
            Echo.private("App.Models.User." + this.authUser.id).notification((notification) => {
                this.getNotifications();
            });
        },
        /**
         * Get all notifications
         * @return void
         */
        getNotifications() {
            axios.get(this.notificationListUrl)
                .then(response => {
                    this.unreadNotifications = response.data.data.unreadNotifications;
                    this.readNotifications = response.data.data.readNotifications;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        /**
         * Mark all notifications as read
         * @return void
         */
        readAll() {
            axios.post(this.notificationReadAllUrl)
                .then(response => {
                    //
                    this.getNotifications();
                    console.log(response.data.message);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        /**
         * Clear all notifications
         * @return void
         */
        clearAll() {
            axios.post(this.notificationClearAllUrl)
                .then(response => {
                    this.getNotifications();
                    console.log(response.data.message);
                })
                .catch(error => {
                    console.log(error);
                });
        },
    }
}
</script>
<style scoped>
.notifications-list {
    list-style: none;
    padding: 0;
    margin: 0;

}

.notifications-list a {
    text-decoration: none;
    color: #000;
}

.notifications-list .active {
    background-color: rgba(129, 126, 126, 0.26);
    border-radius: 5px;
    border-color: rgba(156, 156, 156, 0.377);
}

.notification-icon {
    margin: auto;
}

.notification-icon img {
    border: 1px solid #ddd;
    border-radius: 50%;
    padding: 2px;
}

.notification-panel {
    padding: 0 10px;
    margin: auto;
}

.notification-panel h3 {
    font-size: 1.0rem;
    font-weight: 600;
    margin: 0;
}

.notification-panel p {
    font-size: 0.9rem;
    margin: 0;
}

.notification-date {
    margin: auto;
}

.notifications button {
    background: none;
    border: none;
    color: #000;
    font-size: 0.9rem;
    cursor: pointer;
}
</style>
