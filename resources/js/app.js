
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

Echo.channel('chatroom-channel')
    .listen('ChatroomEvent', (e) => {
        //console.log(e);
        var tbody = document.getElementById('chatroom-tbody');


        var tbodyModified = tbody.innerHTML + 
        '<tr>' +
            '<td class="small text-muted">' + (new Date()).toTimeString().substr(0,5) + '</td>' +
            '<td>' + e.username + '</td>' +
            '<td>' + e.message + '</td>' +
        '</tr>'
        
        tbody.innerHTML = tbodyModified;

        var textField = document.getElementById('chatroom-text-field');
        textField.value = '';
        textField.focus();

        var element = document.getElementById('chatbox');
        element.scrollTop = element.scrollHeight;
    });
