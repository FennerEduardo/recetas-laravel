<template lang="">
    <span v-text="formatearFecha"></span>
</template>

<script>
export default {
    props: ['fecha'],
    // mounted() {
    //     console.log('Se recibio el prop de ', this.fecha);
    // },
    computed: {
        formatearFecha(){
            return moment(this.fecha).locale('es').format('DD [de] MMMM [del] YYYY');
        }
    },
}
</script>