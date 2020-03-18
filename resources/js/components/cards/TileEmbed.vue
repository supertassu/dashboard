<template>
    <tile :position="position" :padding="false">
        <iframe :src="src" class="w-full h-full"></iframe>
    </tile>
</template>

<script>
    import Tile from '../atoms/Tile';

    export default {
        components: {
            Tile,
        },
        props: {
            position: {
                type: String,
                required: true,
            },
            src: {
                type: String,
                required: true
            },
        },
    };
</script>
