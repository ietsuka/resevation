<template>
<div>
  <div class="calendar-title">
    <button class="btn-monthMove prev fa fa-angle-left" v-model="weeksMake"  v-on:click="movePrevWeek">←</button>
     {{weeksMake}}
    <button class="btn-monthMove next fa fa-angle-right" v-model="weeksMake" v-on:click="moveNextWeek">→</button>
  </div>
  <div class="calendar-body">
    <tr class="calendar-body__item">
      <th> </th>
      <th v-for="day in weekly" v-model="weekly" class="day">{{day}}</th>
    </tr>
    <tr class="calendar-detail">
      <tr v-for="(time, index) in nums" :value="time" v-model="nums" class="calendar-detail__item">
        <td>{{time_low(index)}}</td>
        <td v-for="(point, v) in time" @click="showModal(index, v, point)" class="target">{{point}}</td>
      </tr>
    </tr>
  </div>
  <modal-component v-show="showContent" v-on:from-child="closeModal" :date=positionDate :time=positionTime :startDate=date></modal-component>
</div>
</template>

<script>
  import modal from './ModalComponent.vue'
  import Vue from 'vue';
  export default {
    components:{
      'modal-component':modal
    },
    data(){
      return {
        date: null,
        dt: null,
        weeks: null,
        weekly: null,
        nums: null,
        showContent: false,
        positionTime: null,
        positionDate: null
      }
    },
    mounted() {
      axios.get('/api/get')
      .then(response => {
        this.nums = response.data.nums,
        this.date = response.data.from
      })
    },
    methods:{
      time_low(index){
        var TimesEnum = {
          0: "07:00",
          1: "08:00",
          2: "09:00",
          3: "10:00",
          4: "11:00",
          5: "12:00",
          6: "13:00",
          7: "14:00",
          8: "15:00",
          9: "16:00",
          10: "17:00",
          11: "18:00",
          12: "19:00",
          13: "20:00",
          14: "21:00"
        };
        return TimesEnum[index];
      },
      moveNextWeek(){
        var url = '/api/post';
        var params = {
          date: this.date,
          direct: 'next'
        };
        axios.post(url, params)
        .then(function(response){
          this.nums = response.data.nums;
          this.date = response.data.date;
        }.bind(this))
        .catch(function(error){

        });
      },
      movePrevWeek(){
        var url = '/api/post';
        var params = {
          date: this.date,
          direct: 'prev'
        };
        axios.post(url, params)
        .then(function(response){
          this.nums = response.data.nums;
          this.date = response.data.date;
        }.bind(this))
        .catch(function(error){

        });
      },
      showModal(number, date, value){
        if(!value){
          this.showContent = true;
          this.positionTime = number;
          this.positionDate = date;
        }else{
          alert('すでに予約されています。');
        }
      },
      closeModal(){
        this.showContent = false;
        window.location.reload();
      }
    },
    computed:{
      weeksMake(){
        var dt = new Date(this.date);
        var weekly = [];
        var ary = ["日","月","火","水","木","金","土"];
        for(var i = 0; i < 7; i++) {
          var month = dt.getMonth() + 1;
          var date = dt.getDate();
          var day = ary[dt.getDay()];

          dt.setDate(dt.getDate() + 1);
          weekly[i] = month+'/'+date+'('+day+')';
        }

        this.weekly = weekly;
        return weekly[0] +'~'+ weekly[6];
      }
    }
  }
</script>

<style lang="stylus">
.calendar-title{
  text-align: center;
  height: 45px;
  font-size: larger;
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
    th{
      box-sizing: border-box;
      width: 12.28%;
      height: 48px;
      min-height: 48px;
      padding: 12px 0;
      text-align: center;
      cursor:pointer;
      font-size: 12px;
      border: ridge;
      td{
        box-sizing: border-box;
        width: 12.28%;
        height: 48px;
        min-height: 48px;
        padding: 12px 0;
        text-align: center;
        cursor:pointer;
        font-size: 17px;
        border: ridge;
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
    td{
      box-sizing: border-box;
      width: 12.28%;
      height: 48px;
      min-height: 48px;
      padding: 12px 0;
      text-align: center;
      cursor:pointer;
      font-size: 20px;
      border: ridge;
    }
  }
}
</style>
