<template>
<div>
  <div class="calendar-title">
    予約画面
  </div>
  <div class="calendar-content">
    <div class="calendar-function" id="search">
      <ul class="menu">
        <li class="menu__single">
            <a href="#" class="init-bottom">指定日付</a>
            <ul class="menu__second-level">
              <li v-for="date in selectDate" @click="select(date)">{{date}}</li>
            </ul>
        </li>
      </ul>
    </div>
    <div class="calendar-function" id="button">
      <button class="btn-monthMove prev fa fa-angle-left" v-model="weeksMake"  v-on:click="movePrevWeek">←</button>
      <p>{{weeksMake}}</p>
      <button class="btn-monthMove next fa fa-angle-right" v-model="weeksMake" v-on:click="moveNextWeek">→</button>
    </div>
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
  import dayjs from 'dayjs';

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
        positionDate: null,
        three_month: null
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
      },
      select(select_date){
        var url = '/api/post';
        console.log(select_date);
        var params = {
          date: select_date,
          direct: ''
        };
        axios.post(url, params)
        .then(function(response){
          this.nums = response.data.nums;
          this.date = response.data.date;
        }.bind(this))
        .catch(function(error){

        });
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
      },

      selectDate(){
        var three_month = [];
        for(var i = 0; i < 180; i++){
          var day = dayjs().add(i, 'day').format('YYYY/MM/DD');
          three_month[i] = day;
        }

        this.three_month = three_month;
        return this.three_month;
      }
    }
  }
</script>

<style lang="stylus">
.calendar-title{
  font-family: fantasy;
  text-align: center;
  height: 60px;
  font-size: 35px;
}
.calendar-content{
  text-align: center;
  height: 45px;
  font-size: larger;
  display: contents;
  .calendar-function{
    display: inline-flex;
    margin: 0px 382px;
  }
  p{
    font-family: monospace;
  }
  button {
    width: 25px;
    height: 20px;
    margin-top: 17px;
  }
}
#search{
    margin-left auto;

    .menu {
    position: relative;
    width: 460px;
    height: 0px;
    max-width: 1000px;
    margin: 0 auto;
}

}
#button{
  margin-right auto;
}

.menu > li {
    border-radius: 5px;
    float: left;
    width: 25%;
    height: 50px;
    line-height: 50px;
    background: #3c6699;
    list-style: none;
}

.menu > li a {
    display: block;
    color: #fff;
    text-decoration: none;
}

.menu > li a:hover {
    color: #fff;
}

ul.menu__second-level {
    visibility: hidden;
    opacity: 0;
    z-index: 1;
    list-style: none;
    height: auto;
    max-height: 500px;
    overflow-x: scroll;
}

.menu > li:hover {
    background: #3c6699;
    -webkit-transition: all .5s;
    transition: all .5s;
}

.menu__second-level li {
    border-top: 1px solid #225588;
}

.menu__second-level li a:hover {
    background: #3c6699;
}

.init-bottom:after {
    content: '';
    display: inline-block;
    width: 6px;
    height: 6px;
    margin: 0 0 0 15px;
    border-right: 1px solid #fff;
    border-bottom: 1px solid #fff;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}

/* floatクリア */
.menu:before,
.menu:after {
    content: " ";
    display: table;
}

.menu:after {
    clear: both;
}

.menu {
    *zoom: 1;
}
.menu {
  position: relative;
  width: 100%;
  height: 50px;
  max-width: 1000px;
  margin: 0 auto;
}
.menu > li.menu__single {
    position: relative;
    width 120px;
}

li.menu__single ul.menu__second-level {
    position: absolute;
    top: 40px;
    width: 100%;
    background: #3c6699;
    -webkit-transition: all .2s ease;
    transition: all .2s ease;
    padding-left: unset;
}

li.menu__single:hover ul.menu__second-level {
    top: 50px;
    visibility: visible;
    opacity: 1;
    color #fff;
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
      border: 1px solid #3c6699;
      background: linear-gradient(#829ebc,#225588);
      color: white;
      border-radius: 5px;
      font-family: monospace;
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
    font-family: monospace;
    td{
      box-sizing: border-box;
      width: 12.28%;
      height: 48px;
      min-height: 48px;
      padding: 12px 0;
      text-align: center;
      cursor:pointer;
      font-size: 20px;
      border: 1px solid #1b2538;
      border-radius: 5px;
    }
  }
}
</style>
