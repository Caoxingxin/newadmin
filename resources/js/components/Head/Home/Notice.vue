<template>
    <div class="box-card">
        <div v-for="o in 4" :key="o" class="text item">
            {{'列表内容 ' + o }}
        </div>
    </div>
</template>

<script>
export default {
    name: "Notice"
}
</script>

<style scoped>
.box-card {
    background: #ffffff;
    flex: 1;
    border-radius: 5px;
    padding: 20px;
}
.text {
    font-size: 14px;
}
.item {
    margin-bottom: 18px;
}
.clearfix:before,
.clearfix:after {
    display: table;
    content: "";
}
.clearfix:after {
    clear: both;
}
</style>
