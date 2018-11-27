<template>
    <div>
        Holler2
    </div>
</template>
<script>
    import axios from 'axios'
    export default {

        created() {
          // if (parseInt(this.project_id) > 0){
          //     window.Echo.channel('dashboard.' + this.project_id);
          // }
        },
        data() {
            return {
                // project_id: this.$route.query.project
            }
        }
    }
</script>
