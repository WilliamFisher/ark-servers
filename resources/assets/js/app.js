import Datepicker from 'vuejs-datepicker'
import StarRating from 'vue-star-rating'
import swal from 'sweetalert2'
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('star-rating', StarRating);
Vue.component('date-component', {
  components: {
    Datepicker
  },
  template: '<datepicker format="yyyy-MM-dd" inline=true name="lastwipe"></datepicker>'
});

const app = new Vue({
    el: '#app',
    methods: {
      setRating: function (rating) {
        this.rating = rating;
        var pathArray = window.location.pathname.split('/');
        var serverid = pathArray[2];
        axios.get('/servers/' + serverid + '/rate', {
          params: {
            value: this.rating
          }
        })
        .then(function (response) {
          swal('Success', response.data, 'success')
        })
        .catch(function (error) {
          if(error.response.status == 401)
          {
            swal('Error', 'Please login or register.', 'error')
          }else {
            swal('Error', error.message, 'error')
          }
        });
      },
    },
    data: {
      rating: 0
    }
});
