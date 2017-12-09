$(document).ready(function () {
    var pusher = new Pusher('ea424bb08e5891f7d96f', {
        cluster: 'ap1',
        encrypted: true
    });
    var channel = pusher.subscribe('User.Notification.{{UserService::id()}}');
    channel.bind('App\\Events\\NotificationPosted', userNotification);
    function userNotification(data) {
        console.log(data);
    }
});