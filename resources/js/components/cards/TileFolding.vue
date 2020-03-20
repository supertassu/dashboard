<template>
    <tile :position="position">
        <div v-if="error">
            Failed to retrieve folding data <span class="text-red-500">;(</span>
        </div>

        <div v-else-if="loading">
            Still trying to load folding data <span class="text-purple-500 spinner">:I</span>
        </div>

        <div v-else class="flex flex-col justify-between h-full">
            <div>
                <div class="text-gray-500 text-uppercase tracking-wider font-semibold text-lg">
                    <span class="text-gray-600">Folding: </span>{{ folding.name }}
                </div>

                <div>
                    <span class="text-pink-300">█</span>
                    <span class="text-gray-400">Rank</span>
                    <span>{{ folding.rank }}</span>
                    <span class="text-gray-300">of {{ folding.total_teams }}</span>
                </div>

                <div class="mb-2">
                    <span class="text-pink-300">█</span>
                    <span class="text-gray-400">Total WUs</span>
                    <span>{{ folding.wus }}</span>
                </div>

                <div v-for="donor in folding.donors" class="text-sm">
                    <span class="text-pink-300">»</span>
                    <span class="text-gray-300">{{ donor.name }}</span>
                    <span>{{ donor.wus }} WUs</span>
                    <span class="text-gray-500">|</span>
                    <span>{{ donor.credit }}</span>
                </div>
            </div>

            <div class="text-xs text-gray-400">
                <span class="text-pink-100">As of</span> {{ time }}
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
                loading: true,
                at: '',
                folding: [],
                error: null,
            };
        },
        mounted() {
            axios.get(window.baseUrl + '/initial/folding')
                .then(({data}) => {
                    if (!data.folding) {
                        this.error = 'Data was not received';
                    }

                    this.loading = false;
                    this.folding = data.folding;
                    this.at = data.at;
                    this.error = null;
                })
                .catch(error => {
                    this.error = error;
                });
        },
        methods: {
            getEventHandlers() {
                return {
                    'FoldingStatsFetched': ({folding, at}) => {
                        if (!folding) {
                            this.error = 'Data was not received';
                        }

                        this.loading = false;
                        this.folding = folding;
                        this.at = at;
                        this.error = null;
                    },
                };
            },
        },
        computed: {
            time() {
                return moment(this.at)
                    .tz(moment.tz.guess())
                    .format('MMM DD, HH:mm z');
            }
        },
    };
</script>
