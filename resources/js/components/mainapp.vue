<template>

        <div>
            <div>
            <left-sidebar/>
                <navbar/>
            </div>
            <router-view/>
        </div>
</template>


<script>
import LeftSidebar from "../admin/components/layouts/leftSidebar";
import Navbar from "../admin/components/layouts/navbar";
export default {
    components: {LeftSidebar, Navbar},
    data(){
        return {
            data: {
                tagname: ''
            },
            alert: true,
            isAdding: false
        }
    },
    methods: {

    }
}
</script>
