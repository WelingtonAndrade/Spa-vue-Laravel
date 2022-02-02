<template>
    <div>
        <h1 ref="teste">Hooks COmponent</h1>
        <h2>My name is {{ name }}</h2>
    </div>
</template>

<script>
export default {
    name: "Hooks",
    data(){
        return{
            name: 'sadek'
        }
    },
    created() {

    },
    mounted() {
        console.log(this.$refs.teste)
    }
}
</script>

<style scoped>

</style>
