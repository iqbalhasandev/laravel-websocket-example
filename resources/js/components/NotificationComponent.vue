<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <!-- showing notification list  -->
                        <ul class="list-unstyled">
                            <li class="list-group-item list-group-item-action" v-for="notification, key in notifications"
                                :key="key">
                                <a :href="notification.data.click_action">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-2 text-right">
                                                    <i :class="notification.icon"></i>
                                                    <img :src="notification.image" alt="" width="28" height="28"
                                                        class="mx-2">
                                                </div>
                                                <div class="col-md-10">
                                                    <strong>{{ notification.title }}</strong>
                                                    <p>{{ notification.body }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">

                                            <small>{{ notification.data.created_at }}</small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <!-- Add more notifications as needed -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            notifications: [
                {
                    id: 1,
                    title: 'This is demo notification 1',
                    body: 'Donec id elit non mi porta.',
                    image: 'https://via.placeholder.com/150',
                    icon: 'fa fa-bell',
                    data: {
                        click_action: 'https://google.com',
                        created_at: '2019-01-01 00:00:00'
                    }
                },
                {
                    id: 2,
                    title: 'This is demo notification 2',
                    body: 'Donec id elit non mi porta.',
                    image: 'https://via.placeholder.com/150',
                    icon: 'fa fa-bell',
                    data: {
                        click_action: 'https://google.com',
                        created_at: '2019-01-01 00:00:00'
                    }
                },
                {
                    id: 3,
                    title: 'This is demo notification 3',
                    body: 'Donec id elit non mi porta.',
                    image: 'https://via.placeholder.com/150',
                    icon: 'fa fa-bell',
                    data: {
                        click_action: 'https://google.com',
                        created_at: '2019-01-01 00:00:00'
                    }
                }
            ]
        }
    },
    mounted() {
        console.log('Component mounted.')
    },

    created() {
        this.listen();
    },
    methods: {
        listen() {
            console.log("lessing");
            Echo.private("App.Models.User.1").notification(
                (notification) => {
                    console.log(notification);
                    //     this.unreadNotifications.unshift(notification);
                    //     this.$toast.success(notification.data.title, {
                    //         position: "bottom-right",
                    //         timeout: 5000,
                    //         closeOnClick: true,
                    //         pauseOnFocusLoss: true,
                    //         pauseOnHover: true,
                    //         draggable: true,
                    //         draggablePercent: 0.6,
                    //         showCloseButtonOnHover: false,
                    //         hideProgressBar: true,
                    //         closeButton: "button",
                    //         icon: notification.data.icon,
                    //         rtl: false,
                    //     });
                    //     let alertNotify = new Audio(this.alert);
                    //     return alertNotify.play();
                });
        },
    }
}
</script>
