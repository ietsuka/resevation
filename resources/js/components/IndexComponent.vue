<template>
<div>
  <h1 class="h5 mb-4">
    2020年2月のカレンダー
  </h1>
  <div class="calendar-body">
    <div class="calendar-body__item">
      <div> </div>
      <div v-for="day in weeks" class="day">{{day}}</div>
    </div>
    <div class="calendar-detail">
      <div v-for="time in nums" :value="time" class="calendar-detail__item">
        <div v-for="point in chekcSelectedDay(time)" class="target">{{point}}</div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
  export default {
    data(){
      return {
        weeks: null,
        nums: null
      }
    },
    mounted() {
      axios.get('/api/get')
      .then(response => {
        this.weeks = response.data.weekly;
        this.nums = response.data.nums;
      })
    },
    methods:{
      chekcSelectedDay(time){
        const time_low = [...Array(8)].map(i=>" ");
        time_low.splice(0, 1, '11:00');
        Object.keys(time).forEach(function(val) {
          time_low.splice(time[val], 1, '●')
        });
        return time_low;
      },
    }
  }
</script>

<style lang="stylus">
.calendar-title{
  text-align: center;
}
.calendar-body{
  width:100%;
  table-layout:fixed;
  margin-bottom: 20px;
  color: #565656;
  font-size: 1.1rem;
  text-align: center;
  &__item{
    display: flex;
    flex-wrap: wrap;
    div{
      box-sizing: border-box;
      width: 12.28%;
      height: 48px;
      min-height: 48px;
      padding: 12px 0;
      text-align: center;
      cursor:pointer;
      font-size: 12px;
      &:nth-of-type(8n-1){
        color: #5a66a8;
      }
      &:nth-of-type(8n){
        color:#e29a9b;
      }
      div{
        box-sizing: border-box;
        width: 12.28%;
        height: 48px;
        min-height: 48px;
        padding: 12px 0;
        text-align: center;
        cursor:pointer;
        font-size: 17px;
      }
      &.holidays{
         color: #e29a9b;
      }
    }
  }
}

.calendar-detail{
  width:100%;
  table-layout:fixed;
  margin-bottom: 20px;
  color: #565656;
  font-size: 1.1rem;
  text-align: center;
  &__item{
    display: flex;
    flex-wrap: wrap;
    div{
      box-sizing: border-box;
      width: 12.28%;
      height: 48px;
      min-height: 48px;
      padding: 12px 0;
      text-align: center;
      cursor:pointer;
      font-size: 20px;
    }
  }
}
</style>
