<template>
    <tile :position="position">
        <div class="flex flex-col justify-center content-center text-center h-full">
            <span class="text-xl mx-auto">
                <span v-for="icon in weather.icons" v-html="icon"></span>
            </span>

            <div class="text-xl mt-2">
                <span>
                    {{ weather.temperature }}°
                    <span class="text-base uppercase text-gray-500">out</span>
                </span>
            </div>
        </div>
    </tile>
</template>

<script>
    import Tile from '../atoms/Tile';
    import weather from '../../services/Weather';
    import twemoji from 'twemoji';

    export default {
        components: {
            Tile,
        },
        data() {
            return {
                weather: {
                    temperature: '',
                    icons: [],
                },
            };
        },
        props: {
            position: {
                type: String,
                required: true,
            },
            city: {
                type: String,
                required: true
            },
        },
        created() {
            this.fetchWeather();
            setInterval(this.fetchWeather, 15 * 60 * 1000);
        },
        methods: {
            async fetchWeather() {
                const condition = await weather.forCity(this.city);
                const icons = [];

                condition.weather
                    .slice(0, 1) // There's not enough room for > 1 emoji -> only display the first weather condition
                    .forEach(weatherCondition => {
                        const isNight = weatherCondition.icon.includes('n');
                        const icon = weather.getEmoji(weatherCondition.id, isNight);
                        icons.push(twemoji.parse(icon));
                    });

                this.weather.temperature = condition.main.temp.toFixed(1);
                this.weather.icons = icons;
            },
        },
    };
</script>
