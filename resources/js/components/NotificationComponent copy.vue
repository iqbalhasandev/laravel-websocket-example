<template>
    <div class="dropdown dropdown-notification">
        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon feather icon-bell"></i><span
                class="badge badge-pill badge-primary badge-up" v-if="Object.keys(unreadNotifications).length > 0">{{
                    Object.keys(unreadNotifications).length }}</span></a>
        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
            <li class="dropdown-menu-header">
                <div class="dropdown-header m-0 p-2">
                    <h3 class="white">
                        {{ Object.keys(unreadNotifications).length }} New
                    </h3>
                    <span class="grey darken-2">Notifications</span>
                </div>
                <div class="clearfix" v-if="Object.keys(unreadNotifications).length > 0 ||
                    Object.keys(readNotifications).length > 0
                    ">
                    <div class="float-right">
                        <a class="pr-1" @click="markAsRead" v-if="Object.keys(unreadNotifications).length > 0">Mark as
                            read</a>
                        <a class="pr-1" @click="clear">Clear</a>
                    </div>
                </div>
            </li>
            <li class="scrollable-container media-list">
                <!-- notificarion content area -->
                <div class="active" v-for="(notify, index) in unreadNotifications" :key="'I' + index">
                    <a :href="notify.data.link ? notify.data.link : '#'" @click="read(index, notify)">
                        <div class="media d-flex align-items-start justify-content-center">
                            <div class="media-body d-flex">
                                <i v-if="notify.data.icon" :class="notify.data.icon + ' font-medium-5 primary'"></i>
                                <div>
                                    <h6 class="primary media-heading" v-if="notify.data.title">
                                        {{ notify.data.title }}
                                    </h6>
                                    <small class="notification-text text-right" v-if="notify.data.content">{{
                                        notify.data.content }}
                                    </small>
                                </div>
                            </div>
                            <small>
                                <time class="media-meta">{{ notify.created_at }}</time>
                            </small>
                        </div>
                    </a>
                </div>
                <div class="" v-for="(notify, index) in readNotifications" :key="'IQ' + index">
                    <a :href="notify.data.link ? notify.data.link : '#'">
                        <div class="media d-flex align-items-start justify-content-center">
                            <div class="media-body d-flex">
                                <i v-if="notify.data.icon" :class="notify.data.icon + ' font-medium-5 primary'"></i>
                                <div>
                                    <h6 class="primary media-heading" v-if="notify.data.title">
                                        {{ notify.data.title }}
                                    </h6>
                                    <small class="notification-text text-right" v-if="notify.data.content">{{
                                        notify.data.content }}
                                    </small>
                                </div>
                            </div>
                            <small>
                                <time class="media-meta">{{ notify.created_at }}</time>
                            </small>
                        </div>
                    </a>
                </div>

                <div v-if="Object.keys(unreadNotifications).length == 0 &&
                    Object.keys(readNotifications).length == 0
                    " style="min-height: 250px" class="
            d-flex
            justify-content-center
            align-items-center
            text-capitalize text-muted
          ">
                    <p>no Notification available</p>
                </div>
                <!-- End -->
            </li>
            <!-- show all Notification -->
            <li class="dropdown-menu-footer" v-if="Object.keys(unreadNotifications).length > 0 ||
                Object.keys(readNotifications).length > 0
                ">
                <a class="dropdown-item p-1 text-center" href="/admin/notification">Read all notifications</a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ["dataAuthUser"],
    data() {
        return {
            unreadNotifications: [],
            readNotifications: [],
            user: JSON.parse(this.dataAuthUser),
            alert: "admin-assets/alert/alert.mp3",
        };
    },
    created() {
        axios
            .get("/admin/vue-notify")
            .then((res) => {
                this.unreadNotifications = res.data.unreadNotifications;
                this.readNotifications = res.data.readNotifications;
            })
            .catch((err) => {
                console.error(err);
            });
        this.listen();
    },
    methods: {
        listen() {
            console.log("lessing");
            Echo.private("App.Models.User." + this.user.id).notification(
                (notification) => {
                    this.unreadNotifications.unshift(notification);
                    this.$toast.success(notification.data.title, {
                        position: "bottom-right",
                        timeout: 5000,
                        closeOnClick: true,
                        pauseOnFocusLoss: true,
                        pauseOnHover: true,
                        draggable: true,
                        draggablePercent: 0.6,
                        showCloseButtonOnHover: false,
                        hideProgressBar: true,
                        closeButton: "button",
                        icon: notification.data.icon,
                        rtl: false,
                    });
                    let alertNotify = new Audio(this.alert);
                    return alertNotify.play();
                }
            );
        },
        read(index, item) {
            axios
                .get("/admin/vue-notify/" + item.id + "/read")
                .then((res) => {
                    this.unreadNotifications.splice(index, 1);
                    this.readNotifications.unshift(item);
                })
                .catch((err) => {
                    console.error(err);
                });
        },

        clear() {
            axios
                .get("/admin/vue-notify/clear")
                .then((res) => {
                    this.unreadNotifications = [];
                    this.readNotifications = [];
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        markAsRead() {
            axios
                .get("/admin/vue-notify/mark-as-read")
                .then((res) => {
                    this.readNotifications = this.unreadNotifications.concat(
                        this.readNotifications
                    );
                    this.unreadNotifications = [];
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
    watch: {},
};
</script>

<style lang="css" scoped>
.active {
    background: #d8d5d5;
    transition: all 0.5s ease-out;
    border: 1px solid rgb(255 255 255 / 27%);
}
</style>
