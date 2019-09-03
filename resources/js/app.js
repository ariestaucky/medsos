/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

// Notification
var notifications = [];
var notif = [];

const NOTIFICATION_TYPES = {
    follow: 'App\\Notifications\\NewFollower',
    newComment: 'App\\Notifications\\NewComment',
    ImageComment: 'App\\Notifications\\ImageComment',
    newLike: 'App\\Notifications\\NewLike',
    ImageLike: 'App\\Notifications\\ImageLike',
    newMessage: 'App\\Notifications\\NewMessage'
};

$(document).ready(function() {
    // check if there's a logged in user
    if(userId) {
        $.get('/notifications', function (data) {
            addNotifications(data, "#notifications");
        });

        $.get('/messages', function (data) {
            addNotif(data, "#notif_msg");
        });

        window.Echo.private(`App.User.${userId}`)
        .notification((notification) => {
            addNotifications([notification], '#notifications');
            if(notification.type === NOTIFICATION_TYPES.newMessage){
                addNotif([notification], '#msg_notif');
            }
        });

    }
});

function addNotifications(newNotifications, target) {
    notifications = _.concat(notifications, newNotifications);
    // show only last 5 notifications
    notifications.slice(0, 5);
    showNotifications(notifications, target);
}

function showNotifications(notifications, target) {
    if(notifications.length) {
        var htmlElements = notifications.map(function (notification) {
            return makeNotification(notification);
        });
        $('#Notif').html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i>')
        $(target + 'Menu').html(htmlElements.join('')+'<hr class="narrow-hr"><li class="dropdown-header text-center"><a href="/history/'+userId+'">View History</a></li>');
        $(target).addClass('has-notifications')
    } else {
        $(target + 'Menu').html('<li class="dropdown-header">No notifications</li><hr class="narrow-hr"><li class="dropdown-header text-center"><a href="/history/'+userId+'">View History</a></li>');
        $(target).removeClass('has-notifications');
    }
}

// Make a single notification string
function makeNotification(notification) {
    var to = routeNotification(notification);
    var notificationText = makeNotificationText(notification);
    return '<li class="dropdown-header"><a href="' + to + '">' + notificationText + '</a></li>';
}

// get the notification route based on it's type
function routeNotification(notification) {
    var to = '?read=' + notification.id;
    if(notification.type === NOTIFICATION_TYPES.follow) {
        const userId = notification.data.follower_id;
        to = `profile/${userId}` + to;
    } else if(notification.type === NOTIFICATION_TYPES.newComment) {
        const postId = notification.data.post_id;
        to = `posts/${postId}` + to;
    } else if(notification.type === NOTIFICATION_TYPES.ImageComment) {
        const postId = notification.data.post_id;
        to = `Image/${postId}` + to; 
    } else if(notification.type === NOTIFICATION_TYPES.newLike) {
        const postId = notification.data.post_id;
        to = `posts/${postId}` + to;
    } else if(notification.type === NOTIFICATION_TYPES.ImageLike) {
        const postId = notification.data.post_id;
        to = `Image/${postId}` + to;
    }
    return '/' + to;
}

// get the notification text based on it's type
function makeNotificationText(notification) {
    var text = '';
    if(notification.type === NOTIFICATION_TYPES.follow) {
        const name = notification.data.follower_name;
        text += '<strong>' + name + '</strong> followed you';
    } else if(notification.type === NOTIFICATION_TYPES.newComment) {
        const name = notification.data.commenter_name;
        text += `<strong>${name}</strong> comment on your post`;
    } else if(notification.type === NOTIFICATION_TYPES.ImageComment) {
        const name = notification.data.commenter_name;
        text += `<strong>${name}</strong> comment on Image`;
    } else if(notification.type === NOTIFICATION_TYPES.newLike) {
        const name = notification.data.liker_name;
        text += `<strong>${name}</strong> like your post`;
    } else if(notification.type === NOTIFICATION_TYPES.ImageLike) {
        const name = notification.data.liker_name;
        text += `<strong>${name}</strong> like your Image`;
    }
    return text;
}


// Message
function addNotif(newNotifications, target) {
    notif = _.concat(notif, newNotifications);
    // show only last 5 notifications
    notif.slice(0, 5);
    showNotif(notif, target);
}

function showNotif(notif, target) {
    if(notif.length) {
        $('#notif_msg').html('<i class="fa fa-exclamation-circle" aria-hidden="true"></i>');
        $('#msg_notif').addClass('has-notif');
    } else {
        $('#msg_notif').removeClass('has-notif');
    }
}