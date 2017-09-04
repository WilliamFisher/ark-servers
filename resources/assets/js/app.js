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
      showClaimDialog: function () {
        var pathArray = window.location.pathname.split('/');
        var serverid = pathArray[2];
        swal({
          title: 'Claim your server',
          text: "Add 'arkservers:" + serverid + "' to the server's bio.",
          showCancelButton: true,
          confirmButtonText: 'Submit',
          showLoaderOnConfirm: true,
          preConfirm: function (value) {
            return new Promise(function (resolve, reject) {
              setTimeout(function() {
                if (value.length > 16) {
                  reject('Too many characters.')
                } else {
                  axios.get('/servers/' + serverid + '/claim')
                  .then(function (response) {
                    resolve(response.data)
                  })
                  .catch(function (error) {
                    if(error.response.status == 401)
                    {
                      swal('Error', 'Please login or register.', 'error')
                    }
                    else if (error.response.status == 500)
                    {
                      swal('Error', 'Server gamertag could not be found.', 'error')
                    }
                    else
                    {
                      swal('Error', error.message, 'error')
                    }
                  })
                }
              }, 2000)
            })
          },
          allowOutsideClick: false
        }).then(function (value) {
          if(value == 'Success')
          {
            swal({
              type: 'success',
              title: 'Success!',
              text: 'Success! The server is yours.'
            })
          } else {
            swal('Error', 'Could not find code in server bio.', 'error')
          }
        })
      },
    },
    data: {
      rating: 0
    }
});
