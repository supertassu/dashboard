<template>
    <div :style="tilePosition" class="p-1 h-full">
        <div class="grid overflow-hidden rounded bg-gray-990 h-full">
            <div class="p-2" v-if="padding">
                <slot></slot>
            </div>
            <slot v-else></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            position: {
                type: String,
                required: true,
            },
            padding: {
                type: Boolean,
                default: true,
            },
        },

        computed: {
            tilePosition() {
                return `grid-area: ${this.positionToGridAreaNotation(this.position)}`;
            },
        },

        methods: {
            positionToGridAreaNotation(position) {
                const [from, to = null] = position.toLowerCase().split(':');

                if (from.length < 2 || (to && to.length < 2)) {
                    return;
                }

                const areaFrom = `${from.substring(1)} / ${this.indexInAlphabet(from[0])}`;
                const area = to
                    ? `${areaFrom} / ${Number(to.substring(1)) + 1} / ${this.indexInAlphabet(to[0]) + 1}`
                    : areaFrom;

                return area;
            },

            indexInAlphabet(character) {
                const index = character.toLowerCase().charCodeAt(0) - 96;
                return index < 1 ? 1 : index;
            },
        },
    };
</script>
