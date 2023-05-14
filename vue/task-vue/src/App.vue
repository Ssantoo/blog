<template>
  <v-app>
    <div id="app">
      <!-- <img alt="Vue logo" src="./assets/logo.png"> -->
      <!-- Header 컴포넌트를 로그인 또는 회원가입 페이지가 아닌 경우에만 표시 -->
      <Header v-if="!hideHeader" />
      <!-- 라우터 뷰를 통해 각각의 페이지를 렌더링 -->
      <router-view />
    </div>
  </v-app>
</template>

<script>
import Header from "@/components/common/Header.vue";

export default {
  components: {
    Header,
  },
  computed: {
    // 현재 라우트의 이름이 'Login' 또는 'Register'인 경우 true를 반환
    hideHeader() {
      const routeName = this.$route.name;
      return routeName === "Login" || routeName === "Register";
    },
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
