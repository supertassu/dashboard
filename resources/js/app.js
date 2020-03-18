import Vue from 'vue';
import Echo from './echo';

import TileEmbed from './components/cards/TileEmbed';
import TileFitData from './components/cards/TileFitData';
import TileFolding from './components/cards/TileFolding';
import TileSchedule from './components/cards/TileSchedule';
import TileTime from './components/cards/TileTime';
import TileWeather from './components/cards/TileWeather';

window.Pusher = require('pusher-js');


const vue = new Vue({
    el: '#app',
    components: {
        TileEmbed,
        TileFitData,
        TileFolding,
        TileSchedule,
        TileTime,
        TileWeather,
    },
    created() {
        this.echo = new Echo({
            broadcaster: 'pusher',
            key: window.pusherKey,
            cluster: window.pusherCluster,
            disableStats: true,
        });
    },
});
