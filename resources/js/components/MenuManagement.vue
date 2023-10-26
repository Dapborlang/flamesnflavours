<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <category-component></category-component>
            </div>
            <div class="col-sm-6">
                <menu-component></menu-component>
            </div>
        </div>
    </div>
</template>

<script>   
    import CategoryComponent from './CategoryComponent.vue';
    import MenuComponent  from './MenuComponent.vue'; 
    export default 
    {
        data() {
        return {
        };
        },
        methods: {
        },
        components: 
        {
            CategoryComponent,
            MenuComponent,
        },
    };
</script>

<style scoped>

</style>
  