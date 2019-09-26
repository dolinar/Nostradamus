
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

/*const app = new Vue({
    el: '#app',
    created() {
        console.log('123'),
        Echo.channel('chatroom-channel')
            .listen('ChatroomEvent', (e) => {
                console.log(e);
        });
    }
});
*/
//var usersInChannel = 0;
Echo.channel('chatroom-channel')
    // .here((users) => {
    //     usersInChannel = users.length;
    // })
    .listen('ChatroomEvent', (e) => {
        //console.log(e);
        var tbody = document.getElementById('chatroom-tbody');


        var tbodyModified = tbody.innerHTML + 
        // '<span class="badge">' + usersInChannel + '</span>'
        '<tr>' +
            '<td class="small text-muted" style="width:15%">' + (new Date()).toTimeString().substr(0,5) + '</td>' +
            '<td class="small text-muted" style="width:25%">' + e.username + '</td>' +
            '<td style="width:100px;word-break: break-all;">' + e.message + '</td>' +
        '</tr>'
        
        tbody.innerHTML = tbodyModified;

        var element = document.getElementById('chatbox');
        element.scrollTop = element.scrollHeight;
    });
