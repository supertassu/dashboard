<template>
    <tile :position="position">
        <div>
            <div v-for="(day, dayName) in schedule" class="mb-4">
                <span class="text-gray-500 text-uppercase tracking-wider font-semibold text-lg">
                    {{ dayName }}
                </span>
                <div>
                    <div v-for="item in day" class="mb-1 text-gray-300 text-sm flex justify-between">
                        <div class="text-white text-base">{{ item.title }}</div>
                        <div class="flex justify-end text-right">
                            <div>{{ item.teacher }}</div>
                            <div>
                                &nbsp;&middot;&nbsp;{{ formatDate(item.starts_at) }}&ndash;{{ formatDate(item.ends_at) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="schedule.length === 0">
                No events in schedule <span class="text-blue-500">:P</span>
            </div>
        </div>
    </tile>
</template>

<script>
    import Tile from '../atoms/Tile';
    import echo from '../../mixins/echo';
    import axios from 'axios';
    import moment from 'moment-timezone';

    export default {
        mixins: [echo],
        components: {
            Tile,
        },
        props: {
            position: {
                type: String,
                required: true,
            },
        },
        data() {
            return {
                schedule: [],
            };
        },
        mounted() {
            axios.get(window.baseUrl + '/initial/schedule')
                .then(({data}) => {
                    this.schedule = data.schedule;
                });
        },
        methods: {
            getEventHandlers() {
                return {
                    'ScheduleFetched': ({schedule}) => {
                        console.log({schedule});
                        this.schedule = schedule;
                    },
                };
            },
            formatDate(date) {
                return moment(date)
                    .tz(moment.tz.guess())
                    .format('HH:mm');
            }
        },
    };
</script>
