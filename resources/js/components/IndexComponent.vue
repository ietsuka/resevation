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
      <button class="btn-monthMove" v-model="weeksMake"  v-on:click="movePrevWeek">←</button>
      <p>{{weeksMake}}</p>
      <button class="btn-monthMove" v-model="weeksMake" v-on:click="moveNextWeek">→</button>
    </div>
    <div class="calendar-function" id="today">
      <button class="btn-today" v-on:click="today">今日</button>
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
  <div>
      <button class="csv_button" v-on:click="csv">CSV書き出し</button>
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
          alert(error.message);
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
          alert(error.message);
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
          alert(error.message);
        });
      },
      today(){
        var url = '/api/post';
        var today = dayjs().format('YYYY/MM/DD');
        var params = {
          date: today,
          direct: ''
        };
        axios.post(url, params)
        .then(function(response){
          this.nums = response.data.nums;
          this.date = response.data.date;
        }.bind(this))
        .catch(function(error){
          alert(error.message);
        });
      },
      csv(){
        var url = '/api/csv';
        var today = dayjs().format('YYYY/MM/DD');
        var params = {
          date: today,
        };
        axios.post(url, params)
        .then(function(response){
          this.saveCsvFile(response)
        }.bind(this))
        .catch(function(error){
          alert(error.message);
        });
      },
      saveCsvFile(res){
        var blob = new Blob(['\ufeff' + res.data], { type: 'text/csv' })
        const url = window.URL.createObjectURL(blob)
        const link = document.createElement('a')
        var filename = dayjs().format('YYYY/MM/DD');
        link.href = url
        link.setAttribute('download', filename)
        link.click()
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
  font-size: larger;
  display: contents;
  display: flex;
  justify-content: space-between;
  .calendar-function{
    
  }
}
#search{
    .menu {

}

}
#button{
  display: flex;
  justify-content: space-between;
}

#today{
  margin-right: 70px;
}

p{
  font-family: monospace;
  font-size: larger;
  background: linear-gradient(#829ebc, #258);
  color: white;
  border-radius: 5px;
  padding-top: 15px;
  margin 0px;
  height: 35px;
}

.btn-monthMove{
  background: linear-gradient(#829ebc, #258);
  height: 50px;
  color: white;
  font-size: large;
  font-family: fantasy;
  border-radius: 5px;
  padding-top: 10px;
}

.btn-today{
  background: linear-gradient(#829ebc, #258);
  height: 50px;
  width: 70px;
  color: white;
  font-size: large;
  font-family: monospace;
  border-radius: 5px;
  padding-top: 7px;
}

.menu > li {
    border-radius: 5px;
    height: 50px;
    line-height: 50px;
    background: linear-gradient(#829ebc,#225588);
    list-style: none;
    font-family: monospace;
}

.menu > li a {
    font-size: larger;
    color: #fff;
    text-decoration: none;
    padding-top: 4px;
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
    background: linear-gradient(#829ebc,#225588);
    -webkit-transition: all .5s;
    transition: all .5s;
}

.menu__second-level li {
    border-top: 1px solid #225588;
}

.menu__second-level li a:hover {
    background: linear-gradient(#829ebc,#225588);
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

.menu > li.menu__single {
    position: relative;
    width 120px;
    margin-top: -18px;
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

.csv_button{
  background: linear-gradient(#829ebc, #258);
  height: 50px;
  color: white;
  font-size: large;
  font-family: monospace;
  border-radius: 5px;
}
</style>
