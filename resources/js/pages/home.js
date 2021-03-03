let Vue = require('vue').default;
import moment from "moment-mini"
import httpPlugin from './../scripts/http';
import Notifications from 'vue-notification'

Vue.filter('moment', function (value, format) {
    return moment(value).format(format);
});
Vue.filter('timeago', function (value) {
    return moment(value).fromNow();
});

Vue.use(httpPlugin);
Vue.use(Notifications)

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
} catch (e) {}

Vue.component('posts', require('../components/articles/PostsComponent').default);
Vue.component('posts-loading', require('./../components/plugins/loading/PostsLoading').default);

/**
 * Parts
 */
Vue.component('tags', require('./../components/parts/tags').default);
Vue.component('hubs-tags', require('./../components/hubs/HubsTagComponent').default);
Vue.component('select-menu', require('./../components/parts/SelectMenu').default);

Vue.component('vote', require('./../components/parts/vote').default);
Vue.component('favorite', require('./../components/parts/PostFavorite').default);
Vue.component('hub-follow-button', require('./../components/hubs/HubsFollowButtonComponent').default);
Vue.component('comment-favorite', require('./../components/parts/CommentFavorite').default);
Vue.component('pagination', require('./../components/plugins/pagination').default);

import _ from 'lodash';
Vue.prototype.trans = string => _.get(window.i18n, string);

new Vue({
    moment
}).$mount('#app');
