<template>
    <tile :position="position">
        <div class="flex flex-col justify-center content-center text-center h-full">
            <div class="text-gray-500">
                {{ date }}
            </div>

            <div class="text-xl">
                {{ time }}
            </div>
        </div>
    </tile>
</template>

<script>
    import Tile from '../atoms/Tile';
    import moment from 'moment-timezone';

    export default {
        components: {
            Tile,
        },
        props: {
            dateFormat: {
                type: String,
                default: 'DD-MM-YYYY',
            },
            timeFormat: {
                type: String,
                default: 'HH:mm:ss',
            },
            timeZone: {
                type: String,
                required: true,
            },
            position: {
                type: String,
                required: true,
            },
        },
        data() {
            return {
                date: '',
                time: '',
            };
        },
        mounted() {
            this.refreshTime();
            setInterval(this.refreshTime, 1000);
        },
        methods: {
            refreshTime() {
                this.date = moment()
                    .tz(this.timeZone)
                    .format(this.dateFormat);

                this.time = moment()
                    .tz(this.timeZone)
                    .format(this.timeFormat);
            },
        },
    }
</script>
