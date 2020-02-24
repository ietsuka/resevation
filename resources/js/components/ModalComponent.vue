<template>
<div id="overlay">
  <div id="content">
    <h1 class="title">予約登録</h1>
    <h2 class="detail">予約内容は{{dateMake}}の{{time_low(time)}}でよろしいですか？</h2>
    <div class="card-text">
      <div class="form-group">
        <label class="form" for="name">名前:</label>
        <input type="text" class="form-control" id="name" placeholder="名前を入力してください" v-model="name">
      </div>
      <div class="form-group">
        <label class="form" for="id">E-Mail:</label>
        <input type="email" class="form-control" id="email" placeholder="Emailを入力してください" v-model="email">
      </div>
    </div>
    <div class="button-group">
      <button class="submit" v-on:click="clickEvent" :disabled="isValid == false">登録</button>
      <button class="close" v-on:click="closeEvent">閉じる</button>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props:{
    'date': {
      type: Number,
      default: ''
    },
    'time': {
      type: Number,
      default: ''
    },
    'startDate': {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      name:'',
      email:'',
      maxLength: 10
   }
  },
  methods :{
    clickEvent: function(){
      var url = '/api/create';
      var params = {
        date: this.dateMake,
        time: this.time,
        name: this.name,
        email: this.email
      };
      axios.post(url, params)
      .then(function(response){
        alert(response.date.result);
      })
      .catch(function(error){

      });
      this.resetForm();
      this.$emit('from-child');
    },
    closeEvent() {
      this.resetForm();
      this.$emit('from-child');
    },
    resetForm(){
      this.name = '';
      this.email = '';
    },
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
    }
  },
  computed:{
    dateMake() {
      var dt = new Date(this.startDate);
      var year = dt.getFullYear();
      var month = dt.getMonth() + 1;
      var date = dt.getDate() + this.date;
      return year+'/'+month+'/'+date;
    },
    validation() {
      return {
        name  : (!!this.name && this.name.length <= this.maxLength),
        email : (!!this.email)
      }
    },
    isValid() {
      const validation = this.validation
      return Object
        .keys(validation)
        .every(function (key) {
          return validation[key]
        })
    }
  }
}
</script>

<style>
#overlay{
  z-index:1;

  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background-color:rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}
#content{
  border: solid 5px #67c5ff;
  border-radius: 15px;
  z-index:2;
  width:50%;
  height:40%;
  padding: 1em;
  background:#fff;
  text-align: center;
}
.title{
  font-family: fantasy;
}
.detail{
  font-family: serif;
  font-size: larger;
}
.form-group{
	position: relative;
	width: 80%;
	margin: 30px 10%;;
}
.form-group input[type='text'] {
	font: 15px/24px sans-serif;
	box-sizing: border-box;
	width: 100%;
	padding: 0.3em;
	transition: 0.3s;
	letter-spacing: 1px;
	color: #aaaaaa;
	border: 1px solid #1b2538;
	border-radius: 4px;
}
.form input[type='text']:focus {
	border: 1px solid #da3c41;
	outline: none;
	box-shadow: 0 0 5px 1px rgba(218,60,65, .5);
}
.form-group input[type='email'] {
	font: 15px/24px sans-serif;
	box-sizing: border-box;
	width: 100%;
	padding: 0.3em;
	transition: 0.3s;
	letter-spacing: 1px;
	color: #aaaaaa;
	border: 1px solid #1b2538;
	border-radius: 4px;
}
.form input[type='email']:focus {
	border: 1px solid #da3c41;
	outline: none;
	box-shadow: 0 0 5px 1px rgba(218,60,65, .5);
}

.button-group{
  position: relative;
  width: 80%;
  margin: 30px 10%;;
}

.submit {
  display: inline-block;
  padding: 0.6em 2em;
  text-decoration: none;
  color: #67c5ff;
  border: solid 2px #67c5ff;
  border-radius: 3px;
  transition: .4s;
}

.submit:hover {
  background: #67c5ff;
  color: white;
}

.close {
  display: inline-block;
  padding: 0.6em 1.6em;
  text-decoration: none;
  color: #67c5ff;
  border: solid 2px #67c5ff;
  border-radius: 3px;
  transition: .4s;
}

.close:hover {
  background: #67c5ff;
  color: white;
}
</style>
